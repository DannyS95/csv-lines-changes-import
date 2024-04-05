<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\CSV\DataScanners\CSVLinesScanner;
use App\CSV\Processors\CSVLinesProcessor;
use App\Http\Requests\DataFilesDifferenceRequest;
use App\CSV\Specification\CSVLineDifferenceSpecification;

final class CSVLinesDifferenceController extends Controller
{
    public function __invoke(DataFilesDifferenceRequest $request, CSVLineDifferenceSpecification $csvLineDifferenceSpecification)
    {
        $recentFile = $request->file('recentData');
        $oldFile = $request->file('oldData');

        # start processing the files
        $recentDataProcessor = new CSVLinesProcessor($recentFile);
        $oldDataProcessor = new CSVLinesProcessor($oldFile);

        # start reading line by line
        foreach ($oldDataProcessor as $oldData) {
            $oldData = $oldDataProcessor->getCurrentWithHeaders();

            foreach($recentDataProcessor as $recentData) {
                $recentData = $recentDataProcessor->getCurrentWithHeaders();

                # check if it is an existing line in the old file
                if ($csvLineDifferenceSpecification->isSame($oldData, $recentData)) {
                    $oldData = $csvLineDifferenceSpecification->nonIdentifiers($oldData);
                    $recentData = $csvLineDifferenceSpecification->nonIdentifiers($recentData);

                    $scanner = new CSVLinesScanner($oldData, $recentData);
                    
                }
            }
        }
    }
}
