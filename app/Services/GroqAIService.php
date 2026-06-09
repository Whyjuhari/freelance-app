<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class GroqAIService
{
    protected Client $client;
    protected string $apiKey;
    protected string $model;
    protected int $maxTokens;
    protected float $temperature;
    protected string $apiUrl;
    protected array $availableModels;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 60,
            'verify' => true,
            'http_errors' => true,
        ]);

        $this->apiKey = config('ai.groq.api_key');
        $this->model = config('ai.groq.model', 'llama-3.1-70b-versatile');

        // FIX: Cast to proper data types - ini solusi utama untuk error
        $maxTokens = config('ai.groq.max_tokens', 2048);
        $this->maxTokens = is_numeric($maxTokens) ? (int) $maxTokens : 2048;

        $temperature = config('ai.groq.temperature', 0.7);
        $this->temperature = is_numeric($temperature) ? (float) $temperature : 0.7;

        $this->apiUrl = config('ai.groq.api_url', 'https://api.groq.com/openai/v1/chat/completions');
        $this->availableModels = config('ai.available_models', []);

        // Validasi range
        $this->validateParameters();
    }

    /**
     * Validate required configuration
     */
    protected function validateConfig(): void
    {
        if (empty(config('ai.groq.api_key'))) {
            throw new \RuntimeException("Groq API key is missing. Please set GROQ_API_KEY in .env");
        }

        if (empty(config('ai.groq.model'))) {
            throw new \RuntimeException("Groq model is missing. Please set GROQ_MODEL in .env");
        }
    }

    /**
     * Validate parameter ranges
     */
    protected function validateParameters(): void
    {
        // Validasi max_tokens (1-32768 untuk kebanyakan model Groq)
        if ($this->maxTokens < 1) {
            $this->maxTokens = 2048;
            Log::warning('max_tokens terlalu kecil, menggunakan default: 2048');
        }

        if ($this->maxTokens > 32768) {
            $this->maxTokens = 32768;
            Log::warning('max_tokens melebihi batas maksimum, dikurangi menjadi: 32768');
        }

        // Validasi temperature (0.0-2.0)
        if ($this->temperature < 0.0 || $this->temperature > 2.0) {
            $this->temperature = 0.7;
            Log::warning('temperature diluar range yang valid, menggunakan default: 0.7');
        }
    }

    /**
     * Debug configuration values
     */
    public function debugConfig(): array
    {
        return [
            'config' => [
                'max_tokens_raw' => config('ai.groq.max_tokens'),
                'max_tokens_type' => gettype(config('ai.groq.max_tokens')),
                'temperature_raw' => config('ai.groq.temperature'),
                'temperature_type' => gettype(config('ai.groq.temperature')),
            ],
            'instance' => [
                'max_tokens' => $this->maxTokens,
                'max_tokens_type' => gettype($this->maxTokens),
                'temperature' => $this->temperature,
                'temperature_type' => gettype($this->temperature),
                'model' => $this->model,
                'api_url' => $this->apiUrl,
            ]
        ];
    }

    /**
     * Send message to Groq AI with caching option
     */
    public function chat(
        string $message,
        array $context = [],
        array $conversationHistory = [],
        bool $useCache = false,
        int $cacheMinutes = 5
    ): array {
        // Validate input
        $message = trim($message);
        if (empty($message)) {
            return [
                'success' => false,
                'error' => 'Pesan tidak boleh kosong.',
            ];
        }

        if (empty($this->apiKey)) {
            return [
                'success' => false,
                'error' => 'Groq API key belum dikonfigurasi.',
            ];
        }

        if (empty($this->model)) {
            return [
                'success' => false,
                'error' => 'Model AI belum dikonfigurasi.',
            ];
        }

        // Check cache if enabled
        $cacheKey = null;
        if ($useCache) {
            $cacheKey = 'groq_chat_' . md5($message . serialize($context) . serialize($conversationHistory));
            $cached = Cache::get($cacheKey);
            if ($cached !== null) {
                Log::info('Using cached response for key: ' . $cacheKey);
                return $cached;
            }
        }

        try {
            // Prepare messages array
            $messages = $this->prepareMessages($message, $context, $conversationHistory);

            // Make API request
            $response = $this->makeApiRequest($messages);

            // Process response
            $result = $this->processApiResponse($response);

            // Cache result if enabled
            if ($useCache && $cacheKey && $result['success']) {
                Cache::put($cacheKey, $result, $cacheMinutes * 60);
                Log::info('Cached response for key: ' . $cacheKey);
            }

            return $result;
        } catch (GuzzleException $e) {
            return $this->handleApiException($e);
        } catch (\Exception $e) {
            Log::error('Groq Service Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return [
                'success' => false,
                'error' => 'Terjadi kesalahan internal. Silakan coba lagi nanti.',
                'details' => config('app.debug') ? $e->getMessage() : null,
            ];
        }
    }

    /**
     * Prepare messages array for API
     */
    protected function prepareMessages(string $message, array $context, array $history): array
    {
        $messages = [];

        // Add system prompt if context provided
        if (!empty($context)) {
            $systemPrompt = $this->buildSystemPrompt($context);
            if (!empty($systemPrompt)) {
                $messages[] = [
                    'role' => 'system',
                    'content' => $systemPrompt
                ];
            }
        }

        // Add conversation history (limit to last 10 messages untuk efisiensi token)
        $history = array_slice($history, -10);
        foreach ($history as $msg) {
            if (isset($msg['role'], $msg['content']) && in_array($msg['role'], ['user', 'assistant'])) {
                $messages[] = [
                    'role' => $msg['role'],
                    'content' => trim($msg['content'])
                ];
            }
        }

        // Add current user message
        $messages[] = [
            'role' => 'user',
            'content' => $message
        ];

        return $messages;
    }

    /**
     * Make API request to Groq
     */
    protected function makeApiRequest(array $messages): array
    {
        $response = $this->client->post($this->apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => $this->model,
                'messages' => $messages,
                'max_tokens' => $this->maxTokens, // Sekarang sudah integer
                'temperature' => $this->temperature, // Sekarang sudah float
                'top_p' => 1,
                'stream' => false,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Process API response
     */
    protected function processApiResponse(array $response): array
    {
        if (!isset($response['choices'][0]['message']['content'])) {
            Log::error('Invalid Groq API response format', ['response' => $response]);
            throw new \RuntimeException('Format respons API tidak valid');
        }

        return [
            'success' => true,
            'response' => trim($response['choices'][0]['message']['content']),
            'usage' => [
                'prompt_tokens' => $response['usage']['prompt_tokens'] ?? 0,
                'completion_tokens' => $response['usage']['completion_tokens'] ?? 0,
                'total_tokens' => $response['usage']['total_tokens'] ?? 0,
            ],
            'model' => $response['model'] ?? $this->model,
            'finish_reason' => $response['choices'][0]['finish_reason'] ?? null,
            'id' => $response['id'] ?? null,
        ];
    }

    /**
     * Handle API exceptions
     */
    protected function handleApiException(GuzzleException $e): array
    {
        $errorMessage = $e->getMessage();
        $errorBody = '';
        $statusCode = 500;

        Log::error('Groq API Error: ' . $errorMessage);

        if ($e->hasResponse()) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $errorBody = $response->getBody()->getContents();

            Log::error("Groq API Status: {$statusCode}");
            Log::error('Groq API Error Body: ' . $errorBody);

            // Parse error message from response
            try {
                $errorData = json_decode($errorBody, true);
                if (isset($errorData['error']['message'])) {
                    $errorMessage = $errorData['error']['message'];
                }
            } catch (\Exception $parseError) {
                // Ignore parse error
            }
        }

        // User-friendly error messages based on status code
        $userMessage = match (true) {
            $statusCode === 400 => 'Permintaan tidak valid. ' . $errorMessage,
            $statusCode === 401 => 'API key tidak valid. Silakan periksa konfigurasi.',
            $statusCode === 403 => 'Akses ditolak. Pastikan API key memiliki izin yang cukup.',
            $statusCode === 404 => 'Endpoint tidak ditemukan.',
            $statusCode === 429 => 'Terlalu banyak permintaan. Silakan coba lagi nanti.',
            $statusCode === 500 => 'Terjadi kesalahan di server AI. Silakan coba lagi.',
            $statusCode === 503 => 'Layanan AI sedang sibuk. Silakan coba lagi nanti.',
            $statusCode >= 400 && $statusCode < 500 => 'Kesalahan permintaan: ' . $errorMessage,
            default => 'Maaf, terjadi kesalahan saat menghubungi AI. Silakan coba lagi.',
        };

        return [
            'success' => false,
            'error' => $userMessage,
            'details' => config('app.debug') ? $errorMessage : null,
            'status_code' => $statusCode,
            'error_body' => config('app.debug') ? $errorBody : null,
        ];
    }

    /**
     * Build system prompt with user context
     */
    protected function buildSystemPrompt(array $context): string
    {
        $userName = $context['user_name'] ?? 'User';
        $projectsCompleted = (int) ($context['projects_completed'] ?? 0);
        $projectsActive = (int) ($context['projects_active'] ?? 0);
        $totalRevenue = (float) ($context['total_revenue'] ?? 0);
        $clientsActive = (int) ($context['clients_active'] ?? 0);

        // Format currency untuk Indonesia
        $formattedRevenue = 'Rp ' . number_format($totalRevenue, 0, ',', '.');

        // Build upcoming deadlines section
        $upcomingDeadlines = '';
        if (!empty($context['upcoming_deadlines']) && is_array($context['upcoming_deadlines'])) {
            $upcomingDeadlines = "\n\n📅 **Proyek dengan Deadline Terdekat:**\n";
            foreach ($context['upcoming_deadlines'] as $project) {
                $name = $project['name'] ?? 'Proyek Tanpa Nama';
                $client = $project['client'] ?? 'Tanpa Klien';
                $deadline = $project['deadline'] ?? 'Tanggal Tidak Tersedia';
                $daysLeft = $project['days_left'] ?? 0;

                $upcomingDeadlines .= "- **{$name}** (Klien: {$client}, Deadline: {$deadline}, {$daysLeft} hari lagi)\n";
            }
        }

        // Build recent tasks section
        $recentTasks = '';
        if (!empty($context['recent_tasks']) && is_array($context['recent_tasks'])) {
            $recentTasks = "\n\n✅ **Tugas Terbaru:**\n";
            foreach ($context['recent_tasks'] as $task) {
                $title = $task['title'] ?? 'Tugas Tanpa Judul';
                $completed = $task['completed'] ?? false;
                $status = $completed ? '✓ Selesai' : '○ Belum Selesai';
                $recentTasks .= "- {$title} ({$status})\n";
            }
        }

        // Build additional context sections
        $additionalContext = '';
        if (!empty($context['additional_info'])) {
            $additionalContext = "\n\n📝 **Informasi Tambahan:**\n" . $context['additional_info'];
        }

        // Current date for context
        $currentDate = date('d F Y');

        return <<<PROMPT
Kamu adalah AI Assistant untuk FreelanceApp, aplikasi manajemen proyek untuk freelancer Indonesia.
Tanggal hari ini: {$currentDate}
Nama pengguna: {$userName}

**DATA PENGGUNA SAAT INI:**
==========================
📊 **Proyek:**
- Proyek selesai bulan ini: {$projectsCompleted}
- Proyek aktif: {$projectsActive}

💰 **Keuangan:**
- Total pendapatan bulan ini: {$formattedRevenue}

👥 **Klien:**
- Klien aktif: {$clientsActive}
{$upcomingDeadlines}{$recentTasks}{$additionalContext}

**INSTRUKSI PENTING:**
=====================
1. **Bahasa:** SELALU gunakan Bahasa Indonesia yang ramah, natural, dan profesional
2. **Relevansi:** Gunakan data di atas untuk jawaban yang AKURAT dan SPESIFIK
3. **Format Data:** Untuk angka/statistik, berikan data DETAIL dengan format rapi
4. **Nilai Tambah:** Berikan insights dan tips BERGUNA untuk produktivitas freelancer
5. **Visual:** Gunakan emoji relevan (📊💰⏰✅🎯💡) secukupnya
6. **Struktur Response:**
   - Gunakan **bold** untuk informasi penting
   - Gunakan bullet points untuk list
   - Berikan line breaks untuk readability
7. **Kejujuran:** Jika data tidak tersedia, sampaikan dengan jujur dan berikan saran
8. **Proaktif:** Beri peringatan untuk deadline <3 hari, motivasi jika produktivitas turun
9. **Actionable:** SELALU akhiri dengan action item atau tips praktis jika relevan
10. **Scope:** Untuk pertanyaan di luar konteks aplikasi, arahkan kembali ke fitur aplikasi

**CONTOH RESPONSE YANG BAIK:**
User: "Berapa proyek yang selesai?"

AI Response:
"Hai {$userName}! 👋

📊 **Status Proyek Bulan Ini:**
Kamu sudah menyelesaikan **{$projectsCompleted} proyek** bulan ini! 🎉

Saat ini ada **{$projectsActive} proyek aktif** yang berjalan.

💡 **Tips:** Pertahankan momentum ini! Dengan rata-rata ini, kamu bisa selesaikan 50+ proyek setahun."

**PANDUAN TAMBAHAN:**
- **Panjang:** Maksimal 200 kata (kecuali diperlukan detail)
- **Fokus:** Data relevan dan actionable advice
- **Sikap:** Positif dan memotivasi
- **Nilai:** Berikan value, bukan hanya angka
PROMPT;
    }

    /**
     * Format AI response to HTML with sanitization
     */
    public function formatResponse(string $response, bool $sanitize = true): string
    {
        if (empty($response)) {
            return '';
        }

        // Convert markdown-style formatting
        $formatted = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $response);
        $formatted = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $formatted);
        $formatted = preg_replace('/`(.*?)`/', '<code>$1</code>', $formatted);

        // Convert line breaks
        $formatted = nl2br($formatted);

        // Basic sanitization (optional)
        if ($sanitize) {
            $formatted = strip_tags($formatted, '<strong><em><code><br><p><ul><ol><li>');
        }

        return trim($formatted);
    }

    /**
     * Get available models with validation
     */
    public function getAvailableModels(): array
    {
        return array_filter($this->availableModels, function ($model) {
            return is_string($model) && !empty($model);
        });
    }

    /**
     * Change model with validation
     */
    public function setModel(string $model): bool
    {
        $availableModels = array_keys($this->getAvailableModels());

        if (in_array($model, $availableModels, true)) {
            $this->model = $model;
            Log::info("Groq model changed to: {$model}");
            return true;
        }

        Log::warning("Attempt to set invalid Groq model: {$model}");
        return false;
    }

    /**
     * Get current model
     */
    public function getCurrentModel(): string
    {
        return $this->model;
    }

    /**
     * Test API connection
     */
    public function testConnection(): array
    {
        try {
            $response = $this->chat('Halo', ['user_name' => 'Test Connection'], [], false);

            return [
                'success' => $response['success'],
                'message' => $response['success'] ? '✅ Koneksi API Groq berhasil' : '❌ Koneksi API Groq gagal',
                'details' => $response['success'] ? [
                    'model' => $response['model'],
                    'tokens_used' => $response['usage']['total_tokens'],
                ] : $response['error'],
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => '❌ Koneksi API Groq gagal',
                'details' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get usage statistics (mock implementation - perlu disesuaikan dengan tracking Anda)
     */
    public function getUsageStats(): array
    {
        $cacheKey = 'groq_usage_stats_' . date('Y-m-d');

        return Cache::remember($cacheKey, 3600, function () {
            // TODO: Implement actual usage tracking from database
            // Contoh: query database untuk menghitung penggunaan hari ini

            return [
                'requests_today' => 0,
                'tokens_used_today' => 0,
                'tokens_used_month' => 0,
                'daily_limit' => 14400, // Groq free tier daily limit
                'monthly_limit' => 432000, // Groq free tier monthly limit (30 * 14400)
                'remaining_today' => 14400,
                'estimated_cost' => 0,
            ];
        });
    }

    /**
     * Clear cache for specific prefix or all
     */
    public function clearCache(?string $prefix = null): array
    {
        try {
            if ($prefix) {
                Cache::forget($prefix);
                $message = "Cache dengan prefix '{$prefix}' berhasil dihapus";
            } else {
                // Clear all Groq-related caches
                Cache::forget('groq_usage_stats_' . date('Y-m-d'));
                $message = "Semua cache Groq berhasil dihapus";
            }

            return [
                'success' => true,
                'message' => $message,
            ];
        } catch (\Exception $e) {
            Log::error('Failed to clear Groq cache: ' . $e->getMessage());

            return [
                'success' => false,
                'error' => 'Gagal menghapus cache: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Simple health check
     */
    public function healthCheck(): array
    {
        $configStatus = !empty($this->apiKey) && !empty($this->model);
        $paramsStatus = $this->maxTokens > 0 && $this->temperature >= 0;

        return [
            'config' => $configStatus ? '✅ Valid' : '❌ Invalid',
            'parameters' => $paramsStatus ? '✅ Valid' : '❌ Invalid',
            'model' => $this->model,
            'max_tokens' => $this->maxTokens,
            'temperature' => $this->temperature,
            'api_url' => $this->apiUrl,
        ];
    }
}
