<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with('creator:id,name') // Adjust 'id,name' based on your author's table
        ->select('id', 'title', 'author', 'questions_count', 'image_url')
            ->get();

        // Transform each quiz, including converting the author ID to an author name
        $transformedQuizzes = $quizzes->map(function ($quiz) {
            return [
                'id' => $quiz->id,
                'title' => $quiz->title,
                'author' => $quiz->creator->name ?? 'Unknown', // Fallback to 'Unknown' if not found
                'questions_count' => $quiz->questions_count,
                'image_url' => $quiz->image_url ? url($quiz->image_url) : null,
            ];
        });

        return $this->sendResponse(['quizzes' => $transformedQuizzes], 'Get quizzes list');
    }
}
