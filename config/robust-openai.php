<?php

return [
    'log_requests' => true,
    'costs' => [
        'gpt-3.5-turbo-1106' => [
            'prompt_tokens' => 0.0010,
            'completion_tokens' => 0.0020,
        ],
        'gpt-3.5-turbo-instruct' => [
            'prompt_tokens' => 0.0015,
            'completion_tokens' => 0.0020,
        ],
        'gpt-4' => [
            'prompt_tokens' => 0.03,
            'completion_tokens' => 0.06,
        ],
        'gpt-4-32k' => [
            'prompt_tokens' => 0.06,
            'completion_tokens' => 0.12,
        ],
        'gpt-4-0125-preview' => [
            'prompt_tokens' => 0.01,
            'completion_tokens' => 0.03,
        ],
        'gpt-4-1106-preview' => [
            'prompt_tokens' => 0.01,
            'completion_tokens' => 0.03,
        ],
        'gpt-4-1106-vision-preview' => [
            'prompt_tokens' => 0.01,
            'completion_tokens' => 0.03,
        ],
        'gpt-3.5-turbo' => [
            'fine_tuned' => [
                'training_tokens' => 0.0080,
                'prompt_tokens' => 0.0030,
                'completion_tokens' => 0.0060,
            ]
        ],
        'davinci-002' => [
            'fine_tuned' => [
                'training_tokens' => 0.0060,
                'prompt_tokens' => 0.0120,
                'completion_tokens' => 0.0120,
            ]
        ],
        'babbage-002' => [
            'fine_tuned' => [
                'training_tokens' => 0.0004,
                'prompt_tokens' => 0.0016,
                'completion_tokens' => 0.0016,
            ]
        ],
    ]
];
