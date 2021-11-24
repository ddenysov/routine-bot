<?php

namespace App\Command;

use Borsaco\TelegramBotApiBundle\Service\Bot;
use Google_Service_Sheets;
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

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException|\Google\Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $key    = json_decode(file_get_contents('/var/www/html/var/client_secret.json'), true);
        $sheet  = json_decode(file_get_contents('/var/www/html/var/sheet.json'), true);
        $client = new \Google_Client($key);

        $client->setApplicationName('Google Sheets and PHP');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);

        $service       = new Google_Service_Sheets($client);
        $spreadsheetId = $sheet['sheet'];
        $range         = "Tasks!A:E";

        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();

        $this->bot->getBot('first')->sendMessage([
            'chat_id' => '392059332',
            'text'    => $values[rand(1, 4)][3] . ' - ' . $values[rand(1, 4)][0],
        ]);

        $output->writeln('Success');

        return Command::SUCCESS;
    }
}
