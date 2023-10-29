<?php

namespace App\Task;

class Task02 implements TaskInterface
{
    private $taskName = 'test helloapi';
    private $logs = [];
    
    public function taskName(): string
    {
        return $this->taskName;
    }

    public function execute(): void
    {
        
    }
    
    public function logs(): string
    {
        return json_encode($this->logs);
    }
}