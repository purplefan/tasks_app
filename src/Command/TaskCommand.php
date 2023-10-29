<?php

namespace App\Command;

use App\Config\TaskConfig;
use App\Task\TaskInterface;
use \RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


#[AsCommand(
    name: 'app:task',
    description: 'Add a short description for your command',
)]
class TaskCommand extends Command
{
    public function __construct(
        private TaskConfig $taskConfig,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('task', InputArgument::REQUIRED, 'Task number to perform eg. 01')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $taskNumber = $input->getArgument('task');

        if ($taskNumber) {
            $io->note(sprintf('You passed an argument: %s', $taskNumber));
        } else {
            $io->warning('No task number given');
        }
        
        try {
            $task = $this->taskConfig->getTaskClassByName($taskNumber);
         

            $io->info($task->taskName());
            $task->execute();
            $io->info($task->logs());
        } catch (\Exception) {
            throw new RuntimeException('Can\'t find task class');
        }
        
        $io->success('task completed');

        return Command::SUCCESS;
    }
}
