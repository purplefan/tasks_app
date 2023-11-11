<?php

declare(strict_types=1);

namespace App\Service;

enum OpenAiModel: string
{
    case GPT_35_TURBO = 'gpt-3.5-turbo';
    case GPT_4 = 'gpt-4';
    case TEXT_EMBEDDING = 'text-embedding-ada-002';
}
