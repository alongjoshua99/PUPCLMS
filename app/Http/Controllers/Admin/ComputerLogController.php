<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComputerLog;
use Illuminate\Http\Request;

class ComputerLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = ComputerLog::all();
        return view('AMS.backend.admin-layouts.reports.computer.index',  compact('reports'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ComputerLog $computerLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComputerLog $computerLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $status = ComputerLog::findOrFail($id);
            $status->update([
                ''
            ]);

            return redirect()->back()->with('successToast', 'Status updated successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errorAlert', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComputerLog $computerLog)
    {
        //
    }
}
