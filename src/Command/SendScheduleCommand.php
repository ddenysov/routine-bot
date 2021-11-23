<?php

namespace App\Command;

use Borsaco\TelegramBotApiBundle\Service\Bot;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendScheduleCommand extends Command
{

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:send-schedule';
    /**
     * @var \Borsaco\TelegramBotApiBundle\Service\Bot
     */
    private $bot;

    public function __construct(Bot $bot, string $name = null)
    {
        parent::__construct($name);
        $this->bot = $bot;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->bot->getBot('first')->sendMessage([
            'chat_id' => '392059332',
            'text'    => 'Todays number: ' . rand(1, 99999999),
        ]);

        $output->writeln('Success');

        return Command::SUCCESS;
    }
}
