<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function create(CreateProfileRequest $request)
    {
        Profile::create($request->validated());
        return response()->json(
            [
                'message' => 'Profile created successfully!',
            ],
            200,
        );
    }
}
