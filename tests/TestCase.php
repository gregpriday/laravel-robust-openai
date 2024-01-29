<?php

namespace GregPriday\RobustOpenAI\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use OpenAI\Laravel\ServiceProvider as OpenAIServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use GregPriday\RobustOpenAI\RobustOpenAIServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            RobustOpenAIServiceProvider::class,
            OpenAIServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        // Load the openai.php config
        $app['config']->set('openai', require __DIR__.'/../config/openai.php');


        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-robust-openai_table.php.stub';
        $migration->up();
        */
    }
}
