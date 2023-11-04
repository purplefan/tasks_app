<?php

namespace App\Task;
use App\Service\OpenAiClient;

class Task99 implements TaskInterface
{
    private $taskName = 'test open api';
    private $logs = [];

    public function __construct(private OpenAiClient $openAiClient)
    {
    }
    
    public function taskName(): string
    {
        return $this->taskName;
    }

    public function execute(): void
    {
        //$this->logs[] =  $this->openAiClient->testConnection();
    }
    
    public function logs(): string
    {
        return json_encode($this->logs);
    }
}