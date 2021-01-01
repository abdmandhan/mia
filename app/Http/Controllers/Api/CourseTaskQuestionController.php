<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CourseTaskAnswer;
use App\Models\CourseTaskQuestion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use function Psy\debug;

class CourseTaskQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'course_task_id'    => ['required'],
            'question'          => ['required'],
            'question_type_id'  => ['required'],
            'answer'            => ['array', Rule::requiredIf($request->input('question_type_id') == 1)],
            'answer.1'          => [Rule::requiredIf($request->input('question_type_id') == 1)],
            'answer.2'          => [Rule::requiredIf($request->input('question_type_id') == 1)],
            'answer.3'          => [Rule::requiredIf($request->input('question_type_id') == 1)],
            'answer.4'          => [Rule::requiredIf($request->input('question_type_id') == 1)],
            'is_true'           => [Rule::requiredIf($request->input('question_type_id') == 1)]
        ]);

        $course_task_question = CourseTaskQuestion::create([
            'course_task_id'    => $data['course_task_id'],
            'question_type_id'  => $data['question_type_id'],
            'question'          => $data['question']
        ]);

        //IF PG
        if ($data['question_type_id'] == 1) {
            foreach ($data['answer'] as $key => $value) {
                CourseTaskAnswer::create([
                    'course_task_question_id'   => $course_task_question->id,
                    'answer'                    => $value,
                    'is_true'                   => $data['is_true'] == $key ? true : false
                ]);
            }
        }

        return $this->success($course_task_question);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->success(CourseTaskQuestion::with(['question_type'])->where('course_task_id', $id)->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return $this->success(
            CourseTaskQuestion::with([
                'question_type', 'answer'
            ])->find($id)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $request->validate([
            'course_task_id'    => ['required'],
            'question'          => ['required'],
            'question_type_id'  => ['required'],
            'answer'            => ['array', Rule::requiredIf($request->input('question_type_id') == 1)],
            'answer.0'          => [Rule::requiredIf($request->input('question_type_id') == 1)],
            'answer.1'          => [Rule::requiredIf($request->input('question_type_id') == 1)],
            'answer.2'          => [Rule::requiredIf($request->input('question_type_id') == 1)],
            'answer.3'          => [Rule::requiredIf($request->input('question_type_id') == 1)],
            'is_true'           => [Rule::requiredIf($request->input('question_type_id') == 1)]
        ]);

        $course_task_question = CourseTaskQuestion::find($id)->update([
            'course_task_id'    => $data['course_task_id'],
            'question_type_id'  => $data['question_type_id'],
            'question'          => $data['question']
        ]);

        //IF PG
        if ($data['question_type_id'] == 1) {
            foreach ($data['answer'] as $key => $value) {
                CourseTaskAnswer::find($value['id'])->update([
                    'answer'                    => $value['answer'],
                    'is_true'                   => $data['is_true'] == $key ? true : false
                ]);
            }
        } else {
            //ESSAY -> DELETE ALL PG
            CourseTaskAnswer::where('course_task_question_id', $id)->delete();
        }

        return $this->success($course_task_question);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CourseTaskQuestion::find($id)->delete();

        return $this->success();
        //
    }
}
