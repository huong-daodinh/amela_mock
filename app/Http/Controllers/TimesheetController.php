<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::allows('admin')) {
            return view('timesheet.index');
        }
        // must be timesheet of today
        $timesheet = Auth::user()->timesheets;
        $timesheet = $timesheet->where('created_at', '=', Carbon::now()->format('Y-m-d'));
        dd($timesheet);
        return view('timesheet.employee.create', compact('timesheet'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('timesheet.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $startShift = Carbon::createFromTimeString('08:10');
        $endShift = Carbon::createFromTimeString('17:30');

        $timesheet = new Timesheet();
        if ($request->has('check_in')) {
            $date = Carbon::now()->format('Y-m-d');
            if (Carbon::now()->between($startShift, $endShift)) {
                $time = Carbon::now()->format('H:i:s');
                if (Carbon::now()->lte($startShift)) {
                    $check_in_status = 'On Time';
                } else {
                    $check_in_status = 'Late';
                }
                dd($time);
            }
        } else if ($request->has('check_out')) {

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
