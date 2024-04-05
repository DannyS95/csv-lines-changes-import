<?php

namespace App\CSV\Specification;

final class CSVLineDifferenceSpecification
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

    public function isSame(array $line, array $newLine)
    {
        $line = array_values(array_filter($line, function($header) {
            if (in_array($header, $this->columnIdentifiers)) {
                return true;
            }
        }, ARRAY_FILTER_USE_KEY));

        $newLine = array_values(array_filter($newLine, function($header) {
            if (in_array($header, $this->columnIdentifiers)) {
                return true;
            }
        }, ARRAY_FILTER_USE_KEY));

        if (empty(array_diff($line, $newLine))) {
            return true;
        }

        return false;
    }

    public function difference($line, $newLine): array
    {
        if (empty(array_diff($line, $newLine))) {
            $newLine['difference'] = 'unchanged';
        } else {
            $newLine['difference'] = 'unchanged';
        }

        return $newLine;
    }
}
