<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddReadingRequest;
use App\Models\Reading;
use Illuminate\Http\Request;

class ReadingController extends Controller
{
    public function addReading(AddReadingRequest $request)
    {
        Reading::create($request->validated());
        return response()->json(
            [
                'message' => 'Reading details submitted successfully!',
            ],
            200,
        );
    }
}
