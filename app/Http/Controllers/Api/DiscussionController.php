<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $data = Discussion::with(['replies.user:id,name,photo', 'user:id,name,photo', 'type']);

        return $this->success(
            $data->orderBy('created_at', $request->input('order', 'asc'))->paginate(6, ['*'], 'page', $request->input('page', 1))
        );
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
            'text'  => ['required']
        ]);

        $data['user_id'] = Auth::id();
        $data['created_at'] = now();

        $discussion = Discussion::create($data);

        return $this->success($discussion);
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
        Discussion::find($id)->delete();
        return $this->success([], 'success delete disscussion');
    }

    public function storeReply(Request $request)
    {
        $data = $request->validate([
            'discuss_id'    => ['required'],
            'comment'       => ['required']
        ]);

        $reply = DiscussionReply::create([
            'user_id'       => Auth::id(),
            'discuss_id'    => $data['discuss_id'],
            'text'          => $data['comment']
        ]);

        return $this->success($reply);
    }

    public function destroyReply($id)
    {
        DiscussionReply::find($id)->delete();

        return $this->success([], 'success delete comment');
    }
}
