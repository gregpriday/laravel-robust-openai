<?php

namespace GregPriday\RobustOpenAI;

use GregPriday\RobustOpenAI\Middleware\LoggerMiddleware;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleRetry\GuzzleRetryMiddleware;
use OpenAI;
use OpenAI\Client as OpenAIClient;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use GregPriday\RobustOpenAI\Commands\RobustOpenAICommand;

class RobustOpenAIServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('robust-openai')
            ->hasConfigFile()
            ->hasMigration('create_openai_logs_table');
    }

    public function packageBooted()
    {
        // We need an OpenAI client that retries
        $this->app->singleton('openai-robust', static function (): OpenAIClient {
            $apiKey = config('openai.api_key');
            $organization = config('openai.organization');

            // Add the retry middleware
            $stack = HandlerStack::create();
            $stack->push(GuzzleRetryMiddleware::factory(config('openai.retry', [
                'retries' => 5,
                'retry_on_status' => [429, 500, 502, 503, 504],
                'retry_on_timeout' => true,
                'delay' => 1000,
                'multiplier' => 2,
                'max_delay' => 10000,
            ])));

            $stack->push(LoggerMiddleware::factory());

            // Create the client
            $client = new Client([
                'timeout' => config('openai.request_timeout', 30),
                'handler' => $stack,
            ]);

            return OpenAI::factory()
                ->withApiKey($apiKey)
                ->withHttpHeader('OpenAI-Beta', 'assistants=v1')
                ->withOrganization($organization)
                ->withHttpClient($client)
                ->make();
        });
    }
}
