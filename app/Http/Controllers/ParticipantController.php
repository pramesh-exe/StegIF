<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateParticiantRequest;
use App\Http\Requests\HasFinishedRequest;
use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function create(CreateParticiantRequest $request)
    {
        Participant::create($request->validated());
        return response()->json(
            [
                'message' => 'Participant created successfully!',
            ],
            200,
        );
    }

    public function finish(HasFinishedRequest $request)
    {
        Participant::whereId($request->validated()['id'])->update(['has_finished' => true]);
        return response()->json(
            [
                'message' => 'Participant has finished the experiment successfully!',
            ],
            200,
        );
    }
}
