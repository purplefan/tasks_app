<?php

namespace App\Task;

use App\Service\AidevsHttpClient;
use App\Service\OpenAiClient;

class Task08 implements TaskInterface
{
    use TaskTrait;
    private string $taskName = 'rodo';
    private array $logs = [];

    public function __construct(
        private readonly AidevsHttpClient $aidevsHttpClient,
        private readonly OpenAiClient $openAiClient,
    ) {
    }

    public function execute(): void
    {
               
        $token = $this->aidevsHttpClient->retrieveToken($this->taskName);
        $this->logs[] = ['token' => $token];

        $task = $this->aidevsHttpClient->retrieveTask($token);
        $this->logs[] = ['task' => $task];


$answer = <<<'TEXT'
Obfuscate text, use exact placeholders :
- if you find any first name occurrence - replace with "%imie%".
- if you find any last name occurrence - replace with "%nazwisko%"".
- if you find any paid work name occurrence - replace with "%zawod%".
- if you find any city name occurrence - replace with "%miasto%".

Rules:
- Don't translate placeholders
- use exact placeholders provided
TEXT;

        $responseAnswer = $this->aidevsHttpClient->sendAnswer($token, $answer);
        $this->logs[] = $responseAnswer;
    }
}
