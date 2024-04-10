<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserMasterList;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserMasterListImport; // Import the import class (you need to create this)


class UserMasterListController extends Controller
{
    public function index()
    {
        $currentRouteName = app('router')->getRoutes()->match(app('request')->create(url()->current()))->getName();
        $userMasterList = UserMasterList::all();

       // return view('admin.user.usermasterlist.index', compact('userMaster'));
        /* get the current route name */
       // $currentRouteName = app('router')->getRoutes()->match(app('request')->create(url()->current()))->getName();
        return view('AMS.backend.admin-layouts.user.usermasterlist.index', compact('userMasterList'));    
       // return view('admin.user.masterlist.index', compact('userMasterList')); 
        
    }

    public function upload(Request $request)
    {
        $previousRouteName = app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|file|mimes:csv,excel|max:2048',
        ]);

        // Process the uploaded file and insert records into the usermasterlist table
        try {
            Excel::import(new UserMasterListImport, $request->file('file'));

            // If the import was successful, redirect back with a success message
            return redirect()->route('usermasterlist.index')->with('success', 'Bulk upload successful.');

            //return redirect()->route('admin.user.usermasterlist.index')->with('success', 'Bulk upload successful.');
        } catch (\Exception $e) {
            // If an error occurs during import, redirect back with an error message
            return redirect()->back()->with('error', 'Error during bulk upload: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        // Retrieve the UserMasterList record based on the provided ID
        $userMaster = UserMasterList::findOrFail($id);
    
        // Return the view for editing with the retrieved record
        return view('admin.user.usermasterlist.edit', compact('userMaster'));
    }   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /* get the previues route name */
        $previousRouteName = app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();
        $request->validate([
            'file' => 'required|file|mimes:csv,excel|max:2048',
        ]);

        try {
            Excel::import(new UserMasterListImport, $request->file('file'));

            // If the import was successful, redirect back with a success message
            return redirect()->route('usermasterlist.index')->with('success', 'Bulk upload successful.');

            //return redirect()->route('admin.user.usermasterlist.index')->with('success', 'Bulk upload successful.');
        } catch (\Exception $e) {
            // If an error occurs during import, redirect back with an error message
            return redirect()->back()->with('error', 'Error during bulk upload: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
       // $user = User::find($id);
       // $departments = Department::all();
       // $pageTitle = "Faculty - " . $user->facultyMember->getFullName();
       return view('admin.user.usermasterlist.index', compact('userMaster'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $rules = [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'phone' => 'required|string|max:11',
                'department_id' => 'required|integer',
            ];
         //   $user = User::find($id);
          //  if ($user->email == $request->email) {
                $rules['email'] = 'required|string|email|max:255';
           // }
          //  $request->validate($rules);
         //   $user->facultyMember->update([
             //   'first_name' => $request->first_name,
            //    'last_name' => $request->last_name,
            //    'email' => $request->email,
            //    'phone' => $request->phone,
             //   'department_id' => $request->department_id,
             //   'updated_at' => now()
          //  ]);
         //   $user->update([
            //    'email' => $request->email,
            //    'updated_at' => now()
          //  ]);
            return back()->with('successToast', 'Faculty member updated successfully!');
        } catch (\Throwable $th) {
            return back()->with('errorAlert', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
          //  $user = User::find($id);
          //  $user->update([
          //      'status' => "offline",
          //  ]);
          //  return back()->with('successToast', 'User successfully logout!');
        } catch (\Throwable $th) {
            return back()->with('errorAlert', $th->getMessage());
        }
    }
}
