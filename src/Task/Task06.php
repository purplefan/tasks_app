<?php

namespace App\Task;

use App\Service\AidevsHttpClient;
use App\Service\OpenAiClient;
use App\Service\OpenAiRequest\ChatRequest;

class Task06 implements TaskInterface
{
    private string $taskName = 'embedding';
    private array $logs = [];

    public function __construct(
        private readonly AidevsHttpClient $aidevsHttpClient,
        private readonly OpenAiClient $openAiClient,
    ) {
    }
    
    public function taskName(): string
    {
        return $this->taskName;
    }

    public function execute(): void
    {
               
        $token = $this->aidevsHttpClient->retrieveToken($this->taskName);
        $this->logs[] = ['token' => $token];

        $task = $this->aidevsHttpClient->retrieveTask($token);
        $this->logs[] = ['task' => $task];

        $phrase = 'Hawaiian pizza';

        $embedding = $this->openAiClient->embeddings($phrase);

       // $answerArray[] = $embedding;
        //$this->logs[] = ['_answers_'=> $answerArray];


        $responseAnswer = $this->aidevsHttpClient->sendAnswer($token, $embedding);
        $this->logs[] = $responseAnswer;
    }
    
    public function logs(): string
    {
        return json_encode($this->logs, JSON_PRETTY_PRINT);
    }
}