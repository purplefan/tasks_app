<?php

namespace App\Task;

use App\Service\AidevsHttpClient;

class Task01 implements TaskInterface
{
    public function __construct(private readonly AidevsHttpClient $aidevsHttpClient)
    {
    }

    private $taskName = 'helloapi';
    
    private $logs = [];
    
    public function taskName(): string
    {
        return $this->taskName;
    }

    public function execute(): void
    {
        $this->logs[] = 'test';
        
        $taskName = 'helloapi';
        $token = $this->aidevsHttpClient->retrieveToken($taskName);
        $this->logs[] = $token;
        
        $cookie = $this->aidevsHttpClient->retrieveTask($token);
        $this->logs[] = $cookie;

        $responseAnswer = $this->aidevsHttpClient->sendAnswer($token, $cookie['cookie']);
        $this->logs[] = $responseAnswer;
    }
    
    public function logs(): string
    {
        return json_encode($this->logs);
    }
}