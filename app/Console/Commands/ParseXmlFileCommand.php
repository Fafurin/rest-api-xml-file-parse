<?php

namespace App\Console\Commands;

use App\Services\DataToDbService\ArrayToDbService;
use App\Services\ParserService\XmlParserService;
use Illuminate\Console\Command;

class ParseXmlFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:xml {filePath?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsing the xml-file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // получаем путь к файлу (если не указан файл, парсится default.xml)
        $filePath = $this->argument('filePath')
            ? public_path($this->argument('filePath'))
            : public_path('default.xml');

        // парсим файл с помощью сервиса, получаем массив
        $data = XmlParserService::parse($filePath);

        // считаем кол-во элементов, если в xml-файле только один offer offersCount будет 0
        $offersCount = count(array_column($data['offers']['offer'], 'id'));

        if ($offersCount == 0) {
            $value = $data['offers'];
            ArrayToDbService::addDataToDb($value);
        } elseif ($offersCount > 1) {
            $value = $data['offers']['offer'];
            ArrayToDbService::addDataToDb($value);
        } else {
            $this->info('Xml-file is empty');
        }
        $this->info('The data has been successfully added to the database');
    }
}
