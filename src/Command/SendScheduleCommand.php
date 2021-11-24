<?php

namespace App\Command;

use Borsaco\TelegramBotApiBundle\Service\Bot;
use Google_Service_Sheets;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendScheduleCommand extends Command
{
    /**
     * Week days
     */
    const WEEK_DAYSS = [
        1 => 'Понедельник',
        2 => 'Вторник',
        3 => 'Среда',
        4 => 'Четверг',
        5 => 'Пятница',
        6 => 'Суббота',
        7 => 'Воскресенье',
    ];

    /**
     * Ьщтеры
     */
    const MONTH = [
        1  => 'январь',
        2  => 'февраль',
        3  => 'март',
        4  => 'апрель',
        5  => 'мая',
        6  => 'июнь',
        7  => 'июль',
        8  => 'август',
        9  => 'сентябрь',
        10 => 'октябрь',
        11 => 'ноябрь',
        12 => 'декабрь',
    ];

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
        $values   = $response->getValues();

        $result = [
            date('d') . ' ' . self::MONTH[date('m')] . ', ' . self::WEEK_DAYSS[date('N')],
            '',
        ];
        $index  = 0;
        foreach ($values as $key => $value) {
            if ($key === 0) {
                continue;
            }

            $daysDiff = $value[4];

            if ($daysDiff <= 0) {
                $index++;
                $suffix   = $daysDiff < 0 ? " ($daysDiff дней назад)" : ' (сегодня)';
                $result[] = "$index). " . $value[0] . $suffix;
            }
        }

        if ($index > 0) {
            $this->bot->getBot('first')->sendMessage([
                'chat_id' => '392059332',
                'text'    => implode(PHP_EOL, $result),
            ]);
        }

        $output->writeln('Success');

        return Command::SUCCESS;
    }
}
