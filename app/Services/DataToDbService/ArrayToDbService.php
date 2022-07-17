<?php

namespace App\Services\DataToDbService;

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

class ArrayToDbService implements DataToDbServiceInterface
{

    public static function addDataToDb(array $data): void
    {
        // очищаем бд перед парсингом новых данных
        Car::get()->each->delete();

        // в цикле заполняем бд новыми данными
        foreach ($data as $value) {
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

            // получаем из бд марки и модели
            $marks = Mark::get()->pluck('title');
            $carModels = CarModel::get()->pluck('title');

            // проверяем наличие текущей марки и модели в бд
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
        }
    }
}
