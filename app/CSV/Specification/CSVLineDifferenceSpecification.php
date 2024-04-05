<?php

namespace App\CSV\Specification;

class CSVLineDifferenceSpecification
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

    public function isSame(array $lineData, array $lineDataCmp)
    {
        $lineData = array_values(array_filter($lineData, function($header) {
            if (in_array($header, $this->columnIdentifiers)) {
                return true;
            }
        }, ARRAY_FILTER_USE_KEY));

        $lineDataCmp = array_values(array_filter($lineDataCmp, function($header) {
            if (in_array($header, $this->columnIdentifiers)) {
                return true;
            }
        }, ARRAY_FILTER_USE_KEY));

        if (empty(array_diff($lineData, $lineDataCmp))) {
            return true;
        }

        return false;
    }

    public function nonIdentifiers(array $line)
    {
        return array_filter($line, function($key) {
            if (in_array($key, $this->columnIdentifiers) === false) {
                return true;
            }
        }, ARRAY_FILTER_USE_KEY);
    }
}
