<?php

namespace App\Command;

use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;
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
        $message = urlencode('Todays number: ' . rand(1, 99999999));
        $url = "https://api.telegram.org/bot2118172018:AAE3BGPeOkqTw3624TSj9kMi-Y-o40FnkxI/sendMessage?text=$message&chat_id=392059332";

        file_get_contents($url);

        $output->writeln('Success');

        return Command::SUCCESS;
    }
}
