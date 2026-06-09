<?php

namespace App\Http\Controllers;

use App\Services\GroqAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AiAssistantController extends Controller
{
    protected $aiService;

    public function __construct(GroqAIService $aiService)
    {
        // Rate limiting: 30 requests per minute
        // $this->middleware('throttle:30,1');
        $this->aiService = $aiService;
    }

    /**
     * Show AI Assistant page
     */
    public function index()
    {
        $availableModels = $this->aiService->getAvailableModels();
        $usageStats = $this->aiService->getUsageStats();
        $currentModel = session('ai_model', config('ai.groq.model'));

        return view('ai.index', compact('availableModels', 'usageStats', 'currentModel'));
    }

    /**
     * Handle chat request
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
            'conversation_id' => 'nullable|string',
        ]);

        $user = Auth::user();
        $message = $request->input('message');
        $conversationId = $request->input('conversation_id') ?: uniqid('conv_');
        $selectedModel = session('ai_model', config('ai.groq.model'));

        $this->aiService->setModel($selectedModel);

        // Get conversation history if exists
        $conversationHistory = $this->getConversationHistory($conversationId);

        // Get user context data
        $context = $this->getUserContext($user);

        // Send to Groq AI
        $startTime = microtime(true);
        $aiResponse = $this->aiService->chat($message, $context, $conversationHistory);
        $responseTime = round((microtime(true) - $startTime) * 1000); // in milliseconds

        if (!$aiResponse['success']) {
            return response()->json([
                'success' => false,
                'message' => $aiResponse['error'],
                'details' => $aiResponse['details'] ?? null,
            ], 500);
        }

        // Format response
        $formattedResponse = $this->aiService->formatResponse($aiResponse['response']);

        // Save chat history
        $chatId = $this->saveChatHistory(
            $user->id,
            $message,
            $aiResponse['response'],
            $conversationId,
            $aiResponse['usage'],
            $aiResponse['model'] ?? $selectedModel
        );

        // Update conversation history
        $conversationHistory[] = ['role' => 'user', 'content' => $message];
        $conversationHistory[] = ['role' => 'assistant', 'content' => $aiResponse['response']];

        // Keep only last 10 messages for context
        if (count($conversationHistory) > 20) {
            $conversationHistory = array_slice($conversationHistory, -20);
        }

        return response()->json([
            'success' => true,
            'response' => $formattedResponse,
            'raw_response' => $aiResponse['response'],
            'chat_id' => $chatId,
            'conversation_id' => $conversationId,
            'conversation_history' => $conversationHistory,
            'context' => $context,
            'usage' => $aiResponse['usage'] ?? null,
            'model' => $aiResponse['model'] ?? null,
            'response_time_ms' => $responseTime,
        ]);
    }

    /**
     * Get conversation history
     */
    protected function getConversationHistory(?string $conversationId): array
    {
        if (!$conversationId) {
            return [];
        }

        $history = DB::table('ai_chat_history')
            ->where('conversation_id', $conversationId)
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->limit(10) // Last 10 messages
            ->get(['message', 'response']);

        $messages = [];
        foreach ($history as $chat) {
            $messages[] = ['role' => 'user', 'content' => $chat->message];
            $messages[] = ['role' => 'assistant', 'content' => $chat->response];
        }

        return $messages;
    }

    /**
     * Get user context for AI
     */
    protected function getUserContext($user): array
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Projects completed this month
        $projectsCompleted = DB::table('projects')
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->whereBetween('completed_at', [$startOfMonth, $endOfMonth])
            ->count();

        // Active projects
        $projectsActive = DB::table('projects')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->count();

        // Total revenue this month
        $totalRevenue = DB::table('finances')
            ->where('user_id', $user->id)
            ->where('type', 'income')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('amount') ?? 0;

        // Active clients
        $clientsActive = DB::table('clients')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->count();

        // Upcoming deadlines (next 30 days)
        $upcomingDeadlines = DB::table('projects')
            ->join('clients', 'projects.client_id', '=', 'clients.id')
            ->where('projects.user_id', $user->id)
            ->where('projects.status', 'active')
            ->where('projects.deadline', '>=', Carbon::now())
            ->where('projects.deadline', '<=', Carbon::now()->addDays(30))
            ->orderBy('projects.deadline')
            ->limit(5)
            ->get(['projects.name', 'clients.name as client', 'projects.deadline'])
            ->map(function ($project) {
                $deadline = Carbon::parse($project->deadline);
                $daysLeft = Carbon::now()->diffInDays($deadline, false);

                return [
                    'name' => $project->name,
                    'client' => $project->client,
                    'deadline' => $deadline->format('d M Y'),
                    'days_left' => max(0, ceil($daysLeft))
                ];
            })->toArray();

        // Recent tasks (last 10)
        $recentTasks = DB::table('tasks')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get(['title', 'status'])
            ->map(function ($task) {
                return [
                    'title' => $task->title,
                    'completed' => $task->status === 'done'
                ];
            })->toArray();

        return [
            'user_name' => $user->name,
            'projects_completed' => $projectsCompleted,
            'projects_active' => $projectsActive,
            'total_revenue' => $totalRevenue,
            'clients_active' => $clientsActive,
            'upcoming_deadlines' => $upcomingDeadlines,
            'recent_tasks' => $recentTasks,
        ];
    }

    /**
     * Save chat history with conversation tracking
     */
    protected function saveChatHistory(
        int $userId,
        string $message,
        string $response,
        ?string $conversationId,
        ?array $usage,
        string $model
    ): int {
        return DB::table('ai_chat_history')->insertGetId([
            'user_id' => $userId,
            'conversation_id' => $conversationId ?? uniqid('conv_'),
            'message' => $message,
            'response' => $response,
            'tokens_used' => $usage['total_tokens'] ?? 0,
            'model' => $model,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Get chat history
     */
    public function history(Request $request)
    {
        $limit = $request->input('limit', 50);

        $history = DB::table('ai_chat_history')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        $totalTokens = DB::table('ai_chat_history')
            ->where('user_id', Auth::id())
            ->sum('tokens_used');

        return response()->json([
            'success' => true,
            'history' => $history,
            'total_tokens_used' => $totalTokens,
        ]);
    }

    /**
     * Clear chat history
     */
    public function clearHistory()
    {
        DB::table('ai_chat_history')
            ->where('user_id', Auth::id())
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Chat history cleared successfully'
        ]);
    }

    /**
     * Get AI statistics
     */
    public function stats()
    {
        $user = Auth::user();

        $totalChats = DB::table('ai_chat_history')
            ->where('user_id', $user->id)
            ->count();

        $totalTokens = DB::table('ai_chat_history')
            ->where('user_id', $user->id)
            ->sum('tokens_used');

        $chatsToday = DB::table('ai_chat_history')
            ->where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->count();

        return response()->json([
            'success' => true,
            'stats' => [
                'total_chats' => $totalChats,
                'total_tokens' => $totalTokens,
                'chats_today' => $chatsToday,
                'avg_response_time_ms' => null,
                'model' => session('ai_model', config('ai.groq.model')),
            ]
        ]);
    }

    /**
     * Change AI model
     */
    public function changeModel(Request $request)
    {
        $request->validate([
            'model' => 'required|string'
        ]);

        $model = $request->input('model');
        $availableModels = config('ai.available_models');

        if (!array_key_exists($model, $availableModels)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid model selected'
            ], 400);
        }

        // Update user preference or session
        session(['ai_model' => $model]);

        return response()->json([
            'success' => true,
            'message' => 'Model changed successfully',
            'model' => $model,
            'model_name' => $availableModels[$model]
        ]);
    }
}
