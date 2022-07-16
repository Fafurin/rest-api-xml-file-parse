<?php

namespace App\Services;

class XmlParserService implements ParserServiceInterface
{

    public static function parse($filePath): array
    {
        // получаем xml-файл, возвращаем массив
        $xml_data = simplexml_load_file($filePath);
        return json_decode((json_encode($xml_data)), true);
    }
}
