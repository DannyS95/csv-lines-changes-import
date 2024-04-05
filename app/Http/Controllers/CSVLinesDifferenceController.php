<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
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
        $recentCsvProcessor = new CSVLinesProcessor($recentFile);
        $oldCsvProcessor = new CSVLinesProcessor($oldFile);

        # start reading line by line
        $linesCount = iterator_count($recentCsvProcessor);
        $recentCsvProcessor->rewind();
        foreach ($recentCsvProcessor as $recentLine) {
            $recentLine = $recentCsvProcessor->getCurrentWithHeaders();

            foreach($oldCsvProcessor as $oldLine) {
                $oldLine = $recentCsvProcessor->getCurrentWithHeaders();

                # check if it is an existing line in the old file
                if ($csvLineDifferenceSpecification->isSame($oldLine, $recentLine)) {
                    # check if it changed or not
                    $recentLine = $csvLineDifferenceSpecification->difference($oldLine, $recentLine);
                    break;
                } else if ($linesCount === $recentCsvProcessor->key()) {
                    $recentLine['difference'] = 'new';
                }
            }

            dd($recentLine);

            $oldCsvProcessor->rewind();
        }
    }
}
