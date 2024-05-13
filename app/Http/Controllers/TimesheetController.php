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
            $timeCheckin = Carbon::createFromTimeString($request->input('check_in'));
            if ($timeCheckin->between($startShift, $endShift)) {
                $time = $request->input('check_in');
                $date = Carbon::now()->format('Y-m-d');
                if ($timeCheckin->lte($startShift)) {
                    $check_in_status = 'On Time';
                } else {
                    $check_in_status = 'Late';
                }
                Timesheet::create([
                    'user_id' => Auth::user()->id,
                    'check_in' => $time,
                    'check_in_status' => $check_in_status,
                    'date' => $date,
                ]);
                return redirect()->route('timesheet.index')->with('success', 'Checked in successfully');
            } else {
                return redirect()->back()->with('error', 'Today\'s ship has ended');
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
    // public function show(string $id)
    // {
    //     return 'timesheet show ' . $id;
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $timesheet = Timesheet::find($id);
        $user = $timesheet->user;
        return view('timesheet.update', compact('timesheet', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd(1);
        $timesheet = Timesheet::find($id);
        $startShift = Carbon::createFromTimeString('08:10');
        $endShift = Carbon::createFromTimeString('17:30');
        $limit = Carbon::createFromTimeString('19:00');
        $check_in = Carbon::createFromTimeString($request->input('check_in'));
        $check_out = Carbon::createFromTimeString($request->input('check_out'));
        $date = $request->input('date');
        if ($check_in->lte($startShift)) {
            $check_in_status = 'On Time';
        } else {
            $check_in_status = 'Late';
        }
        if ($check_out->lte($endShift)) {
            $check_out_status = 'Left Early';
        } else if ($check_out->gt($endShift) && $check_out->lte($limit) || $request->has('overtime')) {
            $check_out_status = 'Over Time';
        } else {
            $check_out_status = 'Forgot to checkout';
        }
        $timesheet->check_in = $check_in;
        $timesheet->check_out = $check_out;
        $timesheet->check_in_status = $check_in_status;
        $timesheet->check_out_status = $check_out_status;
        $timesheet->date = $date;
        $timesheet->save();
        return redirect()->back()->with('success', 'Timesheet updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd(1);
        $timesheet = Timesheet::find($id);
        $timesheet->delete();
        return redirect()->back()->with('success', 'Timesheet deleted successfully');
    }
}
