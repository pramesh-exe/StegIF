<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTestRequest;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{

    private $score = 0;

    public function create(CreateTestRequest $request)
    {
        $answers = $request->validated();

        // Calculate test score
        $this->calculateScore($answers);
        $answers['score'] = $this->score;

        // Add points per question
        $answers['question1_points'] = $this->pointsPerQuestion['question1'];
        $answers['question2_points'] = $this->pointsPerQuestion['question2'];
        $answers['question3_points'] = $this->pointsPerQuestion['question3'];
        $answers['question4_points'] = $this->pointsPerQuestion['question4'];
        $answers['question5_points'] = $this->pointsPerQuestion['question5'];
        $answers['question6_points'] = $this->pointsPerQuestion['question6'];
        $answers['question7_points'] = $this->pointsPerQuestion['question7'];
        $answers['question8_points'] = $this->pointsPerQuestion['question8'];
        $answers['question9_points'] = $this->pointsPerQuestion['question9'];

        // Send to model
        Test::create($answers);

        // Send response
        return response()->json(
            [
                'message' => 'Knowledge test submitted successfully!',
                'score' => $this->score,
            ],
            200,
        );
    }

    // Correct answers in the test
    private $correctAnswers = [
        'question1' => ["1", "2", "3"],
        'question2' => ["2", "4"],
        'question3' => ["1", "4"],
        'question4' => "4",
        'question5' => "2",
        'question6' => ["1", "2"],
        'question7' => ["4", "5"],
        'question8' => "1",
        'question9' => "5",
    ];

    // When array: left is points to add when correct, right is points to subtract for each wrong ticked box.
    // Max points: 6. When checkbox: points are divided amongst amount of correct and incorrect boxes.
    private $pointsCorrectOrIncorrectAnswers = [
        'question1' => [2, 6],
        'question2' => [3, 3],
        'question3' => [3, 2],
        'question4' => 6,
        'question5' => 6,
        'question6' => [3, 2],
        'question7' => [3, 2],
        'question8' => 6,
        'question9' => 6,
    ];

    // Points that the participant got for each question
    private $pointsPerQuestion = [
        'question1' => 0,
        'question2' => 0,
        'question3' => 0,
        'question4' => 0,
        'question5' => 0,
        'question6' => 0,
        'question7' => 0,
        'question8' => 0,
        'question9' => 0,
    ];

    private function calculateScore(array $answers): void
    {
        // Score calculation logic
        $this->checkCheckboxQuestion('question1', $answers);
        $this->checkCheckboxQuestion('question2', $answers);
        $this->checkCheckboxQuestion('question3', $answers);
        $this->checkRadioQuestion('question4', $answers);
        $this->checkRadioQuestion('question5', $answers);
        $this->checkCheckboxQuestion('question6', $answers);
        $this->checkCheckboxQuestion('question7', $answers);
        $this->checkRadioQuestion('question8', $answers);
        $this->checkRadioQuestion('question9', $answers);
    }

    private function checkRadioQuestion(string $question, array $answers): void
    {
        if ($answers[$question] === "0") {
            // Don't do anything if student does not know the answer
            return;
        }
        if ($this->correctAnswers[$question] === $answers[$question]) {
            // Add points to final score
            $this->score += $this->pointsCorrectOrIncorrectAnswers[$question];
            // Add points to this question
            $this->pointsPerQuestion[$question] = $this->pointsCorrectOrIncorrectAnswers[$question];
        } else {
            // Remove points from final score
            $this->score -= $this->pointsCorrectOrIncorrectAnswers[$question];
            // Save points for this question
            $this->pointsPerQuestion[$question] = -1 * $this->pointsCorrectOrIncorrectAnswers[$question];
        }
    }

    private function checkCheckboxQuestion(string $question, array $answers): void
    {
        if (in_array("0", $answers[$question])) {
            // Don't do anything if student does not know the answer
            return;
        }
        $score = 0;
        foreach ($answers[$question] as $answer) {
            // Check if answer is in the correct answers
            if (in_array($answer, $this->correctAnswers[$question])) {
                $this->score += $this->pointsCorrectOrIncorrectAnswers[$question][0];
                $score += $this->pointsCorrectOrIncorrectAnswers[$question][0];
                continue;
            } else {
                $this->score -= $this->pointsCorrectOrIncorrectAnswers[$question][1];
                $score -= $this->pointsCorrectOrIncorrectAnswers[$question][1];
                continue;
            }
        }
        // Save the points for this individual question
        $this->pointsPerQuestion[$question] = $score;
    }
}
