<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Announcement;
use App\Models\Course;
use App\Models\CourseStudent;
use App\Models\CourseTaskStudent;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function sCourse()
    {
        $ownedCourse = Auth::user()->course()->pluck('course_id');

        return $this->success(Course::whereNotIn('id', $ownedCourse)->with([
            'course_type',
            'course_teacher',
            'grade',
        ])->get());
    }

    public function sCourseDetail($course_id)
    {
        return $this->success(Course::with([
            'course_type',
            'course_teacher.teacher.user_teacher.education',
            'grade',
        ])->find($course_id));
    }

    public function sCourseJoin(Request $request)
    {
        $course = Course::where('id', $request->input('course_id'))->firstOrFail();

        if ($course->is_premium) {
            $data = (object) $request->validate([
                'course_id'     => ['required'],
                'image'         => ['required'],
                'account_name'  => ['required'],
                'account_no'    => ['required']
            ]);
        } else {
            $data = (object) $request->validate([
                'course_id'     => ['required'],
            ]);
        }

        $path = null;

        if ($request->file('image')) {
            $path = 'storage/' . $request->file('image')->store('transaction', 'public');
        }

        $transaction = DB::transaction(function () use ($data, $path, $course) {
            if (!$course->is_premium) {
                CourseStudent::create([
                    'user_id'       => Auth::id(),
                    'course_id'     => $data->course_id,
                ]);

                $course = Course::findOrFail($data->course_id);

                $course_task = $course->course_task()->get();
                foreach ($course_task as $key => $value) {
                    CourseTaskStudent::create([
                        'user_id'           => Auth::id(),
                        'course_id'         => $data->course_id,
                        'course_task_id'    => $value->id,
                    ]);
                }
            }

            return Transaction::create([
                'user_id'               => Auth::id(),
                'course_id'             => $data->course_id,
                'transaction_status_id' => $course->is_premium ? 1 : 2,
                'transaction_date'      => now(),
                'amount'                => Course::find($data->course_id)->price ?? null,
                'image'                 => $path,
                'account_no'            => $data->account_no ?? null,
                'account_name'          => $data->account_name ?? null,
            ]);
        });


        return $this->success($transaction, 'berhasil membeli course');
    }

    public function sTransaction()
    {
        return $this->success(Transaction::where('user_id', Auth::id())->with([
            'transaction_status',
            'user',
            'course'
        ])->get());
    }

    public function sTransactionDetail($transaction_id)
    {
        return $this->success(Transaction::with([
            'transaction_status',
            'user',
            'course'
        ])->find($transaction_id));
    }

    public function sLearning()
    {
        return $this->success(
            CourseStudent::with([
                'course.course_type'
            ])->where('user_id', Auth::id())->get()
        );
    }

    public function sLearningDetail($learning_id)
    {
        return $this->success(CourseStudent::with([
            'course.course_type',
            'course.course_content',
            'course.course_task.difficulty',
        ])->find($learning_id));
    }
}
