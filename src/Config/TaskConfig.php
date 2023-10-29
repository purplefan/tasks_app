<?php

namespace App\Config;


use App\Task\TaskInterface;

class TaskConfig
{
    public function __construct(private array $taskMapping)
    {
    }


    public function getTaskClassByName(string $name): TaskInterface
    {
        return $this->taskMapping[$name];
    }
}
