<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserStudent;
use App\Models\UserTeacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->success(User::with([
            'user_type',
            'user_teacher',
            'user_student'
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
        //
        $data = $request->validate([
            'user_type_id'      => ['required'],
            'name'              => ['required'],
            'email'             => ['required', 'email', 'unique:users'],
            'phone'             => ['required'],
            'address'           => ['required'],
            'photo'             => ['required'],
            'password'             => ['required', 'confirmed'],
        ]);

        if ($request->file('photo')) {
            $path = "";

            if ($request->file('photo')) {
                $path = 'storage/' . $request->file('photo')->store('user', 'public');
            }

            $data['photo'] = $path;
        } else {
            unset($data['photo']);
        }

        User::create($data);

        return $this->success([], 'berhasil membuat user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->success(User::with([
            'user_type',
            'user_teacher',
            'user_student'
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
        //
        $data = $request->validate([
            'user_type_id'      => ['required'],
            'name'              => ['required'],
            'email'             => ['required', 'email', Rule::unique('users')->ignore($id)],
            'phone'             => ['required'],
            'address'           => ['required'],
            'photo'             => ['required'],
        ]);

        if ($request->file('photo')) {
            $path = "";

            if ($request->file('photo')) {
                $path = 'storage/' . $request->file('photo')->store('user', 'public');
            }

            $data['photo'] = $path;
        } else {
            unset($data['photo']);
        }

        User::find($id)->update($data);

        //extra data
        if ($request->input('position_id')) { //jika teacher
            UserTeacher::where('user_id', $id)->update([
                'golongan_id'   => $request->input('golongan_id', 1),
                'education_id'   => $request->input('education_id', 1),
                'position_id'   => $request->input('position_id', 1),
            ]);
        } elseif ($request->input('grade_id')) { //jika student
            UserStudent::where('user_id', $id)->update([
                'grade_id'   => $request->input('grade_id', 1),
            ]);
        }

        return $this->success([], 'berhasil merubah data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        return $this->success();
    }
}
