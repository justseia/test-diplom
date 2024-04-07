<?php

namespace App\Http\Services;

use App\Models\Option;
use Illuminate\Support\Facades\DB;

class Quiz
{
    public function saveOptions($request, $question, $type)
    {

        //update options to db
        $options = $request->options;
        $answers = $request->answer;
        $data = [];

        if ($type == 'choice') {

            foreach($options as $key=>$option) {

                $is_right = $key == $answers ? 1 : 0;

                $data[] = [
                    'question_id' => $question->id,
                    'option' => $option,
                    'is_right_option' => $is_right
                ];
            }
        }

        $isSaved = Option::insert($data);

        return $isSaved;
    }
}
