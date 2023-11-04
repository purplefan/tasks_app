<?php

declare(strict_types=1);

namespace App\Service\OpenAiRequest;

class ChatRequest
{
    public function __construct(
        public readonly string $role,
        public readonly string $content,
    ) { 
    }
}
