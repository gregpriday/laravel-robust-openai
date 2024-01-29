<?php

namespace GregPriday\RobustOpenAI\Tests;

use GregPriday\RobustOpenAI\Facades\OpenAI;
use GregPriday\RobustOpenAI\Facades\RequestLogger;

class TestRequestLogger extends TestCase
{
    public function test_chat_requests()
    {
        $logger = RequestLogger::start(function(){
            $response = OpenAI::chat()
                ->create([
                    'model' => 'gpt-3.5-turbo-1106',
                    'messages' => [
                        ['role' => 'user', 'content' => 'How are you today?']
                    ]
                ]);

            $response = OpenAI::chat()
                ->create([
                    'model' => 'gpt-3.5-turbo-1106',
                    'messages' => [
                        ['role' => 'user', 'content' => 'What is the best word?']
                    ]
                ]);
        });

        dd($logger->toArray());
    }

    public function test_embedding_request()
    {
        $response = OpenAI::embeddings()
            ->create([
                'model' => 'text-embedding-3-large',
                'input' => 'The food was delicious and the waiter...',
            ]);
    }
}
