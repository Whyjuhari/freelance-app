<?php

return [
    'groq' => [
        'api_key' => env('GROQ_API_KEY'),
        'model' => env('GROQ_MODEL', 'llama-3.3-70b-versatile'),
        'max_tokens' => env('GROQ_MAX_TOKENS', 2048),
        'temperature' => env('GROQ_TEMPERATURE', 0.7),
        'api_url' => 'https://api.groq.com/openai/v1/chat/completions',
    ],

    'available_models' => [
        'llama-3.3-70b-versatile' => 'Llama 3.3 70B (Best for Indonesian)',
        'llama-3.1-8b-instant' => 'Llama 3.1 8B (Super Fast)',
        'mixtral-8x7b-32768' => 'Mixtral 8x7B (Long Context)',
        'gemma2-9b-it' => 'Gemma 2 9B (Google)',
    ],
];