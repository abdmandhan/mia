<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Models\Tryout;
use App\Models\TryoutAnswer;
use App\Models\TryoutStudent;
use App\Models\TryoutStudentAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TryoutController extends Controller
{
    //
    public function index()
    {
        return $this->success(
            Tryout::with(['difficulty'])->get()->append(['student_assign'])
        );
    }

    public function store(Request $request)
    {
        $data = (object) $request->input();
        $try_out_student = TryoutStudent::where('user_id', Auth::id())->where('tryout_id', $data->id)->first();
        if (!$try_out_student) {
            TryoutStudent::create([
                'user_id'       => Auth::id(),
                'tryout_id'    => $data->id,
                'start_date'    => now(),
            ]);
        }

        return $this->success();
    }

    public function show($id)
    {
        $tryout_student = TryoutStudent::where('tryout_id', $id)->first();
        if (!$tryout_student->score) {
            $data = Tryout::with([
                'tryout_question.tryout_answer'
            ])->find($id);

            return $this->success($data);
        }

        return $this->failed();
    }

    public function update(Request $request, $id)
    {
        $answer = $request->input('answer');

        $total_score = 0;
        foreach ($answer as $key => $value) {
            $data = [
                'user_id'       => Auth::id(),
                'tryout_id'       => $id,
                'question_id'   => $key,
                'answer_id'     => $value,
            ];

            if (TryoutAnswer::find($value)->is_true) $total_score++;

            TryoutStudentAnswer::updateOrCreate([
                'user_id'           => Auth::id(),
                'tryout_id'         => $id,
                'question_id'       => $key,
            ], $data);
        }

        if ($total_score != 0) {
            $score = $total_score / count($answer) * 100;
        } else {
            $score = 0;
        }

        $course_task_student = TryoutStudent::where('user_id', Auth::id())->where('tryout_id', $id);
        $course_task_student->update([
            'finish_date'   => now(),
            'score'         => $score
        ]);

        return $this->success();
    }
}
