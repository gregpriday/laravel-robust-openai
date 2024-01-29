<?php

namespace GregPriday\RobustOpenAI\Commands;

use Illuminate\Console\Command;

class RobustOpenAICommand extends Command
{
    public $signature = 'laravel-robust-openai';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
