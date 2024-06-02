<?php

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/authenticate', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        // Check if the user is a student and has a schedule today
        if (Auth::user()->role->name === 'student') {
            $hasSchedule = checkIfStudentHasSchedule(Auth::user()->student->section_id);

            // If the student has no schedule, log them out
            if (!$hasSchedule) {
                Auth::user()->status = "Offline";
                // Logout the user
                Auth::logout();
                return response()->json(['success' => false, 'message' => 'You have no schedule today'], 401);
            }
            // If the student has no schedule, log them out
            // if (checkIfComputerIsNotOccupied($request->ip())) {
            //     return $this->handleForceLogOut($request, 'Computer is already occupied');
            // }

            updateComputerStatus($request, 'login');
            $schedule = getTheScheduleOfStudent(Auth::user()->student->section_id);
            $attendance = createStudentTimeInAttendance($schedule, Auth::user()->student->id, $request->ip());
            // Authentication was successful...
            Auth::user()->status = "Online";
            Auth::user()->save();

            Log::create([
                'user_id' => Auth::id(),
                'action' => 'login',
                'time_in' => now(),
            ]);

            // Save last_activity into session
            // $request->session()->regenerate();
            // $request->session()->put(Auth::id() . '_last_activity', now());

            return response()->json(['success' => true]);
        }
    }
    return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
});
