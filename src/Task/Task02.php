<?php

namespace App\Task;

use App\Service\AidevsHttpClient;
use App\Service\OpenAiClient;

class Task02 implements TaskInterface
{
    private string $taskName = 'moderation';
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

        $moderationResults = $this->openAiClient->moderations($task['input']);
        //$this->logs[] = ['moderations'=> $moderationResults];
        $answerArray = [];
        foreach ($moderationResults as $moderationResult) {
            $answerArray[] = (int)$moderationResult['flagged'];
        }
        $this->logs[] = ['_answers_'=> $answerArray];


        $responseAnswer = $this->aidevsHttpClient->sendAnswer($token, $answerArray);
        $this->logs[] = $responseAnswer;
    }
    
    public function logs(): string
    {
        return json_encode($this->logs, JSON_PRETTY_PRINT);
    }
}