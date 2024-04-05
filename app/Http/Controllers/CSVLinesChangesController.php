<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules\File;
use App\CSV\Processors\CSVLinesProcessor;
use App\Http\Requests\CSVLinesChangesRequest;
use App\CSV\Specification\CSVLineChangesSpecification;

final class CSVLinesChangesController extends Controller
{
    public function __invoke(CSVLinesChangesRequest $request, CSVLineChangesSpecification $csvLineDifferenceSpecification): JsonResponse
    {
        $recentFile = $request->file('recentFile');
        $oldFile = $request->file('oldFile');

        $request->validate(
            [
                'recentFile' => [
                    File::types(['csv', 'txt'])
                    ->size(intval(bcadd(bcdiv($oldFile->getSize(), 1024), 1)))
                    ->max(intval(bcmul(12, 1024))),
                ],
            ],
            [
                'recentFile.between' => 'The recent csv must contain more lines than the older CSV.'
            ]
        );

        # start processing the files
        $recentCsvProcessor = new CSVLinesProcessor($recentFile);
        $oldCsvProcessor = new CSVLinesProcessor($oldFile);

        # start reading line by line
        $linesCount = iterator_count($oldCsvProcessor);
        $linesCount--;

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
