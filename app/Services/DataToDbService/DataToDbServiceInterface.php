<?php

namespace App\Services\DataToDbService;

interface DataToDbServiceInterface
{
    public static function addDataToDb(array $data): void;
}
