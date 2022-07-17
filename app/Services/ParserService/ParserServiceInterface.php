<?php

namespace App\Services;

interface ParserServiceInterface
{
    public static function parse(string $filePath): array;
}
