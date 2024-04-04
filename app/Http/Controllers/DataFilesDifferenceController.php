<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Processors\DataFileProcessor;
use App\Http\Requests\DataFilesDifferenceRequest;

final class DataFilesDifferenceController extends Controller
{
    public function __invoke(DataFilesDifferenceRequest $request)
    {
        $recentFile = $request->file('recentData');
        $oldFile = $request->file('oldData');

        # start processing the files, so we can compare each line by column
        $recentDataProcessor = new DataFileProcessor($recentFile);
        $oldDataProcessor = new DataFileProcessor($oldFile);

        foreach ($oldDataProcessor as $data) {
            dd($data);
        }
        die();

    }
}
