<?php

namespace App\Task;

interface TaskInterface
{
    public function taskName(): string;
    public function execute(): void;
    public function logs(): string;
}