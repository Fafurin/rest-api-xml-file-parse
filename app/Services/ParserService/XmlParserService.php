<?php

namespace App\Services\ParserService;

class XmlParserService implements ParserServiceInterface
{
    public static function parse($filePath): array
    {
        // получаем xml-файл, возвращаем массив
        if (file_exists($filePath)) {
            $xml_data = simplexml_load_file($filePath);
        } else {
            exit("Could not open the file $filePath");
        }
        return json_decode((json_encode($xml_data)), true);
    }
}
