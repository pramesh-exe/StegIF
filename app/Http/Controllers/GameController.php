<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddGameNodeRequest;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function addGameNode(AddGameNodeRequest $request)
    {
        Game::create($request->validated());
        return response()->json(
            [
                'message' => 'Game node added successfully!',
            ],
            200,
        );
    }
}
