<?php

declare(strict_types=1);

namespace App\Task;

trait TaskTrait
{
    public function taskName(): string
    {
        return $this->taskName;
    }
    
    public function logs(): string
    {
        return json_encode($this->logs, JSON_PRETTY_PRINT);
    }
}
