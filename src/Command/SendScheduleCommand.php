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
        $bot_api_key  = '2118172018:AAE3BGPeOkqTw3624TSj9kMi-Y-o40FnkxI';
        $bot_username = 'ATLAS_DAILY_BOT';
        $hook_url     = 'http://152.70.178.2:8000';

        try {
            // Create Telegram API object
            $telegram = new Telegram($bot_api_key, $bot_username);

            // Set webhook
            $result = $telegram->setWebhook($hook_url);
            if ($result->isOk()) {
                echo $result->getDescription();
            }
        } catch (TelegramException $e) {
            // log telegram errors
            // echo $e->getMessage();
        }

        $output->writeln('Success');

        return Command::SUCCESS;
    }
}
