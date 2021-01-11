<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tryout;
use App\Models\TryoutAnswer;
use App\Models\TryoutQuestion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TryoutQuestionController extends Controller
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
        $data = $request->validate([
            'tryout_id'         => ['required'],
            'question'          => ['required'],
            'answer'            => ['array', Rule::requiredIf($request->input('question_type_id') == 1)],
            'answer.0'          => ['required'],
            'answer.1'          => ['required'],
            'answer.2'          => ['required'],
            'answer.3'          => ['required'],
            'is_true'           => ['required']
        ]);

        $tryout_question = TryoutQuestion::create([
            'tryout_id'     => $data['tryout_id'],
            'question'      => $data['question']
        ]);

        foreach ($data['answer'] as $key => $value) {
            TryoutAnswer::create([
                'tryout_question_id'    => $tryout_question->id,
                'answer'                => $value,
                'is_true'               => $data['is_true'] == $key ? true : false
            ]);
        }

        return $this->success(TryoutQuestion::with(['tryout_answer'])->find($tryout_question->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->success(TryoutQuestion::with([
            'tryout_answer'
        ])->find($id));
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
        $data = $request->validate([
            'question'          => ['required'],
            'answer'            => ['array', Rule::requiredIf($request->input('question_type_id') == 1)],
            'answer.0'          => ['required'],
            'answer.1'          => ['required'],
            'answer.2'          => ['required'],
            'answer.3'          => ['required'],
            'is_true'           => ['required', 'numeric']
        ]);

        TryoutQuestion::find($id)->update(['question' => $data['question']]);

        foreach ($data['answer'] as $key => $value) {
            $is_true = $data['is_true'] == $value['id'] ? 1 : 0;

            TryoutAnswer::find($value['id'])->update([
                'answer'                => $value['answer'],
                'is_true'               => $is_true
            ]);
        }

        return $this->success(TryoutQuestion::with(['tryout_answer'])->find($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
