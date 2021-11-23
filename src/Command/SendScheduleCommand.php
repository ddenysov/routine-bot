<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendScheduleCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:send-schedule';

    /**
     * Configure
     */
    protected function configure(): void
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Success');

        return Command::SUCCESS;
    }
}
