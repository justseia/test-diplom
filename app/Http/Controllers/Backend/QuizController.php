<?php

namespace App\Http\Controllers\Backend;

use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Services\Quiz as SaveQuizOption;

class QuizController extends Controller
{
    public function __construct(
        Quiz     $quiz,
        Option   $option,
        Question $question
    )
    {
        $this->quiz = $quiz;
        $this->option = $option;
        $this->question = $question;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $quizs = $this->quiz->with('creator')->withCount('participants')->get();
        if ($request->quiz_id) {
            $selectedquiz = $quizs->where('id', $request->quiz_id)->first();
        } else {
            $selectedquiz = $quizs->first();
        }
        return view('backend.quiz.index', ['quizzes' => $quizs, 'selectedquiz' => $selectedquiz]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.quiz.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $quiz = new $this->quiz;
        $quiz->title = $request->name;
        $quiz->author = auth()->user()->id;
        $quiz->save();

        if ($request->hasFile('images')) {
            $file = $request->file('images');
            $path = $file->store('public');
            $fileName = basename($path);
            $quiz->image_url = $fileName;
            $quiz->save();
        }

        return redirect()->action([QuizController::Class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $quiz = $this->quiz->where('id', $id)->firstOrFail();

        $questions = $this->question->with('options')
            ->where('quiz_id', $quiz->id)->get();

        return view('backend.quiz.edit', [
            'quiz' => $quiz,
            'questions' => $questions,
            'type' => 'choice'
        ]);
    }
    public function questions($id)
    {
        $quiz = $this->quiz->where('id', $id)->firstOrFail();

        $questions = $this->question->with('options')
            ->where('quiz_id', $quiz->id)->get();

        return view('backend.quiz.edit', [
            'quiz' => $quiz,
            'questions' => $questions,
            'type' => 'choice'
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        // DB::transaction(function() use ($slug, $request) {

        $this->validate($request, [
            'question' => 'required',
            'options.*' => 'required'
        ]);

        $type = $request->type;
        $quiz = $this->quiz->where('id', $id)->firstOrFail();

        //update question to db
        $question = new Question;
        $question->quiz_id = $quiz->id;
        $question->question = $request->question;
        $question->save();

        $saveOption = (new SaveQuizOption)->saveOptions($request, $question, $type);

        // });

        return redirect()->route('quiz.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        DB::transaction(function () use ($request) {
            $quiz = $this->quiz->with('questions.options')->where('id', $request->id);
            $quiz->delete();
        });

        return redirect()->route('quiz.index')->with('success', 'Record deleted successfully.');
    }

    public function inactivate(Request $request)
    {
        $quiz = Quiz::find($request->id);
        $quiz->is_active = 0;
        $quiz->save();
        return redirect()->route('quiz.index');

    }
    public function activate(Request $request)
    {
        $quiz = Quiz::find($request->id);
        $quiz->is_active = 1;
        $quiz->save();
        return redirect()->route('quiz.index');

    }
}
