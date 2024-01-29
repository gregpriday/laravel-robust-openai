<?php

namespace GregPriday\RobustOpenAI\Tests;

use GregPriday\RobustOpenAI\Facades\OpenAI;
use GregPriday\RobustOpenAI\Facades\RequestLogger;
use http\Env\Request;

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

        dd($logger->cost());
    }

    public function test_embedding_request()
    {
        RequestLogger::start();
        $response = OpenAI::embeddings()
            ->create([
                'model' => 'text-embedding-3-large',
                'input' => 'The food was delicious and the waiter...',
            ]);

        $logger = RequestLogger::stop();
    }
}
