<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tryout;
use Illuminate\Http\Request;

class TryoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->success(Tryout::with([
            'difficulty',
        ])->get());
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
            'name'              => ['required'],
            'difficulty_id'     => ['required'],
            'date_start'        => ['required', 'date'],
            'date_finish'       => ['required', 'date', 'after:date_start'],
            'time'              => ['required'],
            'is_show_review'    => ['required']
        ]);

        $tryout = Tryout::create($data);

        return $this->success($tryout);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->success(Tryout::with([
            'difficulty',
            'tryout_question'
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
            'name'              => ['required'],
            'difficulty_id'     => ['required'],
            'date_start'        => ['required', 'date'],
            'date_finish'       => ['required', 'date', 'after:date_start'],
            'time'              => ['required'],
            'is_show_review'    => ['required']
        ]);

        Tryout::find($id)->update($data);

        return $this->success($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tryout::find($id)->delete();

        return $this->success();
    }
}
