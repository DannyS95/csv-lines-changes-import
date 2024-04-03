<?php

namespace App\Http\Controllers;

use App\Http\Requests\DataFilesDifferenceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DataFilesDifferenceController extends Controller
{
    public function __invoke(DataFilesDifferenceRequest $request): RedirectResponse
    {
    }
}
