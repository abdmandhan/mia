<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Models\CourseType;
use Illuminate\Http\Request;

class CourseTypeController extends Controller
{
    public $header = [
        [
            'text'      => 'ID',
            'value'     => 'id',
            'component' => 'v-text-field',
            'disabled'  => true
        ],
        [
            'text'      => 'Name',
            'value'     => 'name',
            'component' => 'v-text-field'
        ],
        [
            'text'      => 'Actions',
            'value'     => 'actions',
            'sortable'  => false
        ],
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->success([
            'data'      => CourseType::all(),
            'header'    => $this->header,
            'config'    => [
                'can_delete'    => false
            ]
        ]);
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
            'name'     => ['required'],
        ]);

        if ($id = $request->input('id')) {
            //update
            CourseType::find($id)->update($data);
        } else {
            CourseType::create($data);
        }

        return $this->success();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        CourseType::find($id)->delete();

        return $this->success();
    }
}
