<?php

namespace App\Http\Controllers;

use App\Models\Computer;
use App\Models\Log;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentMasterList;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{

    /* generate a home function and add comment */
    public function home()
    {
        return view('AMS.frontend.home.index');
    }
    public function register(Request $request)
    {

        try {
            $request->validate([
                'student_no' => 'required|unique:students,student_no',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:students,email',
                'phone' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required|same:password',
                'section_id' => 'required',
                'section_id' => 'required',
            ]);
            $master_list = StudentMasterList::where('student_id_number', $request->student_no)->first();
            $master_list_count = StudentMasterList::count();
            if ($master_list_count == 0) {
                return redirect()->back()->with('errorAlert', 'No Masterlist');
            }
            if (!$master_list) {
                return redirect()->back()->with('errorAlert', 'Invalid Student Number');
            }
            $id =  Student::create([
                'student_no' => $request->student_no,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => Str::lower($request->email),
                'phone' => $request->phone,
                'address' => $request->address,
                'section_id' => $request->section_id,
                'course_id' => Section::find($request->section_id)->course->id,
                'sy_id' => SchoolYear::where('is_active', true)->first()->id,
            ])->id;
            User::create([
                'email' => Str::lower($request->email),
                'password' => Hash::make($request->password),
                'role_id' => 4,
                'student_id' => $id,
            ]);
            return redirect()->route('login.index')->with('successToast', 'Registration Successful');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errorAlert', $th->getMessage());
        }
    }
    public function registrationForm()
    {
        $sections = Section::all();
        return view('AMS.frontend.register.index', compact('sections'));
    }
    public function loginForm()
    {
        return view('AMS.frontend.login.index');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            // Check if the user is a student and has a schedule today
            if (Auth::user()->role->name === 'student') {
                $hasSchedule = checkIfStudentHasSchedule(Auth::user()->student->section_id);

                // If the student has no schedule, log them out
                if (!$hasSchedule) {
                    return $this->handleForceLogOut($request, 'You have no schedule today');
                }
                // If the student has no schedule, log them out
                // if (checkIfComputerIsNotOccupied($request->ip())) {
                //     return $this->handleForceLogOut($request, 'Computer is already occupied');
                // }

                updateComputerStatus($request, 'login');
                $schedule = getTheScheduleOfStudent(Auth::user()->student->section_id);
                $attendance = createStudentTimeInAttendance($schedule, Auth::user()->student->id, $request->ip());
            }

            // Authentication was successful...
            Auth::user()->status = "Online";
            Auth::user()->save();

            Log::create([
                'user_id' => Auth::id(),
                'action' => 'login',
                'time_in' => now(),
            ]);

            // Save last_activity into session
            $request->session()->regenerate();
            $request->session()->put(Auth::id() . '_last_activity', now());

            // Redirect users based on their roles
            if (Auth::user()->force_change_password) {
                return redirect()->intended(route(Auth::user()->role->name . '.change-password.index'));
            }
            switch (Auth::user()->role->name) {
                case 'admin':
                    return redirect()->intended(route('admin.dashboard.index'));
                case 'faculty':
                    return redirect()->intended(route('faculty.dashboard.index'));
                case 'student':
                    return redirect()->intended(route('student.dashboard.index'));
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    protected function handleNoSchedule(Request $request): Response
    {
        // Remove last_activity from session
        $request->session()->forget(Auth::id() . "_last_activity");

        // Set the user's status to offline
        Auth::user()->status = "Offline";
        // Regenerate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // Logout the user
        Auth::logout();
        return redirect()->route('home.index')->with('errorAlert', 'You have no schedule today');
    }
    protected function handleForceLogOut(Request $request, $message): Response
    {
        // Remove last_activity from session
        $request->session()->forget(Auth::id() . "_last_activity");

        // Set the user's status to offline
        Auth::user()->status = "Offline";
        // Regenerate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // Logout the user
        Auth::logout();
        return redirect()->route('home.index')->with('errorAlert', $message);
    }
    public function logout(Request $request)
    {

        if (Auth::user()->role->name === 'student') {
            updateComputerStatus($request, 'logout');
            $schedule = getTheScheduleOfStudent(Auth::user()->student->section_id);
            $attendance = createStudentTimeOutAttendance($schedule, Auth::user()->student->id);
            // dd($attendance);
        }
        // remove last_activity from session
        $request->session()->forget(Auth::id() . "_last_activity");
        // set the user's status to offline
        Auth::user()->status = "Offline";
        Auth::user()->save();
        // create a log
        $log = Log::where('user_id', Auth::id())
            ->whereNull('time_out')
            ->latest()
            ->first();

        $log->update([
            'time_out' => now(),
        ]);


        //regenerate   session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // logout the user
        Auth::logout();

        return redirect()->route('home.index');
    }
}
