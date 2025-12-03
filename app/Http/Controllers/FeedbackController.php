<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFeedbackRequest;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function create(CreateFeedbackRequest $request)
    {
        Feedback::create($request->validated());
        return response()->json(
            [
                'message' => 'Feedback added successfully!',
            ],
            200,
        );
    }
}
