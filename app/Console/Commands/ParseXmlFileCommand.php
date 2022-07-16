<?php

namespace App\Console\Commands;

use App\Models\BodyType;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\Color;
use App\Models\EngineType;
use App\Models\GearType;
use App\Models\Generation;
use App\Models\Mark;
use App\Models\Transmission;
use App\Models\Year;
use App\Services\XmlParserService;
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

        // очищаем бд перед парсингом новых данных
        Car::get()->each->delete();

        if (count($data['offers']['offer']) > 1) {
            foreach ($data['offers']['offer'] as $key => $value) {
                $color = Color::firstOrCreate(['title' => $value['color']]);
                $year = Year::firstOrCreate(['title' => $value['year']]);
                $bodyType = BodyType::firstOrCreate(['title' => $value['body-type']]);
                $engineType = EngineType::firstOrCreate(['title' => $value['engine-type']]);
                $gearType = GearType::firstOrCreate(['title' => $value['gear-type']]);
                $transmission = Transmission::firstOrCreate(['title' => $value['transmission']]);

                $carArray = [
                    'id' => $value['id'],
                    'year_id' => $year->id,
                    'run' => $value['run'],
                    'color_id' => $color->id,
                    'body_type_id' => $bodyType->id,
                    'engine_type_id' => $engineType->id,
                    'transmission_id' => $transmission->id,
                    'gear_type_id' => $gearType->id,
                ];

                $car = Car::firstOrCreate($carArray);

                $marks = Mark::get()->pluck('title');
                $carModels = CarModel::get()->pluck('title');

                if (!($marks->contains($value['mark']))) {
                    $mark = new Mark(['title' => $value['mark']]);
                    $car->mark()->save($mark);

                    if (!($carModels->contains($value['model']))) {
                        $carModel = new CarModel(['title' => $value['model']]);
                        $mark->carModels()->save($carModel);

                        if (empty($value['generation_id'])) {
                            $generation = new Generation([
                                'title' => null,
                                'generation_id' => null
                            ]);
                        } else {
                            $generation = new Generation([
                                'title' => $value['generation'],
                                'generation_id' => $value['generation_id']
                            ]);
                            $carModel->generations()->save($generation);
                        }
                    }
                }
                $this->info($value['mark'] . ' ' . $value['model'] . ' added to the database');
            }
        } else {
            $this->info('Xml-file is empty');
        }
        $this->info('The data has been successfully added to the database');
    }
}
