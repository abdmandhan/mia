<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseType;
use App\Models\Difficulty;
use App\Models\Grade;
use App\Models\QuestionType;
use App\Models\User;
use App\Rules\PasswordSanctum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $data = (object) $request->validate([
            'email'     => ['required', 'string', 'exists:users'],
            'password'  => ['required', 'string', new PasswordSanctum],
        ]);

        $user = User::with(['user_type'])->where('email', $data->email)->first();

        if (Hash::check($data->password, $user->password)) {
            return $this->success([
                'user'  => $user,
                'token' =>  $user->createToken('URS')->plainTextToken,
                'options'   => $this->options()
            ], 'success login');
        } else {
            return $this->failed([], 'password salah', 400);
        }
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'          => ['required', 'string'],
            'phone'         => ['required', 'numeric'],
            'address'       => ['required'],
            'email'         => ['required', 'string', 'unique:users'],
            'password'      => ['required', 'string', 'confirmed'],
        ]);

        $data['user_type_id'] = 3; //Student

        $user = User::create($data);

        return $this->success([
            'user'  => $user,
            'token' =>  $user->createToken('URS')->plainTextToken
        ], 'success verify');
    }

    public function verify()
    {
        $user = User::with(['user_type'])->find(Auth::id());

        return $this->success([
            'user'  => $user,
            'token' =>  $user->createToken('URS')->plainTextToken,
            'options'   => $this->options()
        ], 'success verify');
    }

    public function options()
    {
        $data = [
            'grades'        => Grade::all(['id', 'name']),
            'course_types'  => CourseType::all(['id', 'name']),
            'courses'       => Course::all(['id', 'name']),
            'difficulties'  => Difficulty::all(['id', 'name']),
            'question_types'  => QuestionType::all(['id', 'name']),
            'teachers'       => User::where('user_type_id', 2)->get(['id', 'name'])
        ];

        return $data;
    }
}
