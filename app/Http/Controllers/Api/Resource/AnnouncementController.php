<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public $header = [
        [
            'text'      => 'ID',
            'value'     => 'id',
            'component' => 'v-text-field',
            'disabled'  => true
        ],
        [
            'text'      => 'Title',
            'value'     => 'title',
            'component' => 'v-text-field'
        ],
        [
            'text'      => 'Content',
            'value'     => 'content',
            'component' => 'v-textarea'
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
        return $this->success([
            'data'      => Announcement::all(),
            'header'    => $this->header,
            'config'    => [
                'can_delete'    => true
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
        $data = $request->validate([
            'title'     => ['required'],
            'content'   => ['required']
        ]);

        if ($id = $request->input('id')) {
            //update
            Announcement::find($id)->update($data);
        } else {
            Announcement::create($data);
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
        Announcement::find($id)->delete();

        return $this->success();
    }
}
