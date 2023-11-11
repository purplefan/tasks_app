<?php

namespace App\Task;

use App\Service\AidevsHttpClient;
use App\Service\OpenAiClient;
use App\Service\OpenAiRequest\ChatRequest;

class Task07 implements TaskInterface
{
    private string $taskName = 'functions';
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

        $addUserDef = [
            'name' => 'addUser',
            'description' => 'Adds user',
            'parameters' => [
                'type' => 'object',
                'properties' => [
                    'name'=> [
                        'type'=> 'string',
                        'description' => 'user name',
                    ],
                    'surname'=> [
                        'type'=> 'string',
                        'description' => 'user surname',
                    ],
                    'year'=> [
                        'type'=> 'integer',
                        'description' => 'year born',
                    ],
                ],
            ],
        ];


        $this->logs[] = ['_answers_'=> $addUserDef];


        $responseAnswer = $this->aidevsHttpClient->sendAnswer($token, $addUserDef);
        $this->logs[] = $responseAnswer;
    }
    
    public function logs(): string
    {
        return json_encode($this->logs, JSON_PRETTY_PRINT);
    }
}