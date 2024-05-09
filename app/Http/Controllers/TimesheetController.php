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
            $timesheets = Timesheet::query()->paginate(15);
            return view('timesheet.index', compact('timesheets'));
        }
        $timesheets = Timesheet::query()->where('user_id', '=', Auth::user()->id)->paginate(15);
        // dd($timesheets);
        return view('timesheet.employee.index', compact('timesheets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::allows('admin')) {
            return view('timesheet.create');
        }
        $timesheet = Timesheet::query()
        ->where('date', '=', Carbon::now()->format('Y-m-d'))
        ->where('user_id', '=', Auth::user()->id)->get();
        $timesheet = $timesheet->first();
        return view('timesheet.employee.create', compact('timesheet'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $startShift = Carbon::createFromTimeString('08:10');
        $endShift = Carbon::createFromTimeString('17:30');
        $limit = Carbon::createFromTimeString('19:00');
        if ($request->has('check_in')) {
            // dd($request->input('check_in'));
            $timeCheckin = Carbon::createFromTimeString($request->input('check_in'));
            if ($timeCheckin->between($startShift, $endShift)) {
                $time = $request->input('check_in');
                $date = Carbon::now()->format('Y-m-d');
                if (Carbon::now()->lte($startShift)) {
                    $check_in_status = 'On Time';
                    dd($check_in_status);
                } else {
                    $check_in_status = 'Late';
                    // dd($check_in_status);
                }
                // dd($time, $date, $check_in_status);
                Timesheet::create([
                    'user_id' => Auth::user()->id,
                    'check_in' => $time,
                    'check_in_status' => $check_in_status,
                    'date' => $date,
                ]);
                return redirect()->route('timesheet.index')->with('success', 'Checked in successfully');
            } else {

            }
        } else if ($request->has('check_out')) {
            $time = $request->input('check_out');
            $timeCheckout = Carbon::createFromTimeString($request->input('check_out'));
            $search = [
                ['user_id', '=', Auth::user()->id],
                ['date', '=', Carbon::now()->format('Y-m-d')]
            ];
            $todayTimeSheet = Timesheet::query()->where($search)->first();
            if ($timeCheckout->lte($endShift)) {
                $check_out_status = 'Left Early';
            } else if ($timeCheckout->gt($endShift) && $timeCheckout->lte($limit)) {
                $check_out_status = 'Over Time';
            } else {
                $check_out_status = 'Forgot to checkout';
            }
            $todayTimeSheet->check_out_status = $check_out_status;
            $todayTimeSheet->check_out = $time;
            $todayTimeSheet->save();
            return redirect()->route('timesheet.index')->with('success', 'Checked out successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $timesheet = Timesheet::find($id);
        // return view()
        return 'timesheet show ' . $id;
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
