<?php

namespace App\Services\ParserService;

interface ParserServiceInterface
{
    public static function parse(string $filePath): array;
}
