<?php

namespace App\CSV\Specification;

final class CSVLineChangesSpecification
{
    private array $columnIdentifiers = [];
    public function __construct() {
        $this->columnIdentifiers = [
            'cnpj',
            'pdf_file_name',
            'balance_date',
            'balance_refers_to_date',
        ];
    }

    public function isSame(array $line, array $recentLine)
    {
        $line = array_values(array_filter($line, function($header) {
            if (in_array($header, $this->columnIdentifiers)) {
                return true;
            }
        }, ARRAY_FILTER_USE_KEY));

        $recentLine = array_values(array_filter($recentLine, function($header) {
            if (in_array($header, $this->columnIdentifiers)) {
                return true;
            }
        }, ARRAY_FILTER_USE_KEY));

        if (empty(array_diff($recentLine, $line))) {
            return true;
        }

        return false;
    }

    public function change($line, $recentLine): string
    {
        if (empty(array_diff(array_values($this->keyValueConcat($recentLine)), array_values($this->keyValueConcat($line))))) {
            return 'unchanged';
        }

        return 'changed';
    }

    private function keyValueConcat(array $arr): array
    {
        return array_map(function($k, $v){
            return "$k=$v";
        }, array_keys($arr), array_values($arr));
    }
}
