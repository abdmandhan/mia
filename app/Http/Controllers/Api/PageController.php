<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    //
    public function dashboard()
    {
        $date_now = date_format(date_create(now()), 'yy-m-d');
        $absensi = Absensi::where('user_id', Auth::id())->where('date', '>=', $date_now)->first();
        if ($absensi == null) {
            Absensi::create([
                'user_id'   => Auth::id(),
                'date'      => now()
            ]);
        }

        return $this->success([
            'announcements' => Announcement::all(),
            'absensi'       => Absensi::where('user_id', Auth::id())->get()
        ]);
    }

    public function teacher()
    {
        return $this->success(User::with([
            'user_teacher.education',
            'user_teacher.position',
            'user_teacher.golongan',
        ])->where('user_type_id', 2)->get());
    }
}
