<?php

namespace GregPriday\RobustOpenAI\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \OpenAI\Resources\Assistants assistants()
 * @method static \OpenAI\Resources\Audio audio()
 * @method static \OpenAI\Resources\Chat chat()
 * @method static \OpenAI\Resources\Completions completions()
 * @method static \OpenAI\Resources\Embeddings embeddings()
 * @method static \OpenAI\Resources\Edits edits()
 * @method static \OpenAI\Resources\Files files()
 * @method static \OpenAI\Resources\FineTunes fineTunes()
 * @method static \OpenAI\Resources\Images images()
 * @method static \OpenAI\Resources\Models models()
 * @method static \OpenAI\Resources\Moderations moderations()
 * @method static \OpenAI\Resources\Threads threads()
 */
class OpenAI extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'openai-robust';
    }
}
