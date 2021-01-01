<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CourseContent;
use App\Rules\Youtube;
use Illuminate\Http\Request;

class CourseContentController extends Controller
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
            'course_id' => 'required',
            'name'      => 'required',
            'desc'      => 'required',
            'content'   => 'required',
            'file'      => ['required', 'file', 'mimes:pdf'],
            'url_youtube'     => ['required', new Youtube()]
        ]);

        $path = "";

        if ($request->file('file')) {
            $path = 'storage/' . $request->file('file')->store('course/file', 'public');
        }

        $data['file'] = $path;

        $courseContent = CourseContent::create($data);

        return $this->success($courseContent);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->success(CourseContent::where('course_id', $id)->get());
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
        return $this->success(CourseContent::find($id));
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
            'name'          => ['required'],
            'desc'          => ['required'],
            'content'       => ['required'],
            'file'          => ['required'],
            'url_youtube'   => ['required', new Youtube],
        ]);

        //check jika filenya beda
        if ($request->file('file')) {
            $path = "";

            if ($request->file('file')) {
                $path = 'storage/' . $request->file('file')->store('course/file', 'public');
            }

            $data['file'] = $path;
        }

        $courseContent = CourseContent::find($id)->update($data);

        return $this->success($courseContent);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CourseContent::find($id)->delete();

        return $this->success();
    }
}
