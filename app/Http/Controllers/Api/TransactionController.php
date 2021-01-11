<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CourseStudent;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->success(Transaction::with([
            'transaction_status',
            'user',
            'course'
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
            'user_id'                   => ['required'],
            'course_id'                 => ['required'],
            'transaction_status_id'     => ['required'],
            'transaction_date'          => ['required'],
            'amount'                    => ['required'],
            'image'                     => ['required', 'image'],
            'account_no'                => ['required'],
            'account_name'              => ['required'],
        ]);

        $path = 'storage/' . $request->file('image')->store('transaction', 'public');
        $data['image'] = $path;

        $transaction = Transaction::create($data);

        if ($transaction->transaction_status_id == 2) {
            CourseStudent::create([
                'user_id'       => $transaction->user_id,
                'course_id'     => $transaction->course_id,
            ]);
        }

        return $this->success($transaction);
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
        return $this->success(Transaction::with([
            'user',
            'transaction_status',
            'course'
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
        $request->validate([
            'transaction_status_id' => ['required']
        ]);

        Transaction::find($id)->update([
            'transaction_status_id' => $request->input('transaction_status_id')
        ]);

        $transaction = Transaction::find($id);

        if ($transaction->transaction_status_id == 2) {
            CourseStudent::create([
                'user_id'       => $transaction->user_id,
                'course_id'     => $transaction->course_id,
            ]);
        }

        return $this->success([], 'berhasil update transaction');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Transaction::find($id)->delete();

        return $this->success();
    }
}
