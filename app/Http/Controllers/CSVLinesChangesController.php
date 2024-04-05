<?php

namespace App\Http\Controllers;

use App\CSV\Processors\CSVLinesProcessor;
use App\Http\Requests\DataFilesDifferenceRequest;
use App\CSV\Specification\CSVLineChangesSpecification;
use Illuminate\Http\JsonResponse;

final class CSVLinesChangesController extends Controller
{
    public function __invoke(DataFilesDifferenceRequest $request, CSVLineChangesSpecification $csvLineDifferenceSpecification): JsonResponse
    {
        $recentFile = $request->file('recentData');
        $oldFile = $request->file('oldData');

        # start processing the files
        $recentCsvProcessor = new CSVLinesProcessor($recentFile);
        $oldCsvProcessor = new CSVLinesProcessor($oldFile);

        # start reading line by line
        $linesCount = iterator_count($oldCsvProcessor);
        $linesCount--;

        $request->validate([
            'recentData' => ["gt:$linesCount"],
        ], ['recentData.gt' => 'The recent csv must contain more data than the older CSV.']);

        $recentCsvProcessor->rewind();
        $linesChanges = [array_merge($recentCsvProcessor->getHeaders(), ['change'])];

        foreach ($recentCsvProcessor as $recentLine) {
            $recentLine = $recentCsvProcessor->getCurrentWithHeaders();

            foreach($oldCsvProcessor as $oldLine) {
                $oldLine = $oldCsvProcessor->getCurrentWithHeaders();

                # check if it is an existing line in the old file
                if ($csvLineDifferenceSpecification->isSame($oldLine, $recentLine)) {
                    # check if it changed or not
                    $recentLine['change'] = $csvLineDifferenceSpecification->change($oldLine, $recentLine);
                    break;
                } else if ($linesCount === $oldCsvProcessor->key()) {
                    $recentLine['change'] = 'new';
                    break;
                }
            }

            $oldCsvProcessor->rewind();

            $linesChanges[1][] = array_values($recentLine);
        }

        $lineChanges['headers'][] = 'change';

        return response()->json($linesChanges);
    }
}
