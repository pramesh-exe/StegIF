<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUESRequest;
use App\Models\UES;
use Illuminate\Http\Request;

class UESController extends Controller
{
    public function create(CreateUESRequest $request)
    {
        UES::create($request->validated());
        return response()->json(
            [
                'message' => 'User Engagement Scale submitted successfully!',
            ],
            200,
        );
    }
}
