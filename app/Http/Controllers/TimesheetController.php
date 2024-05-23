<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->all());
        $query = Timesheet::query();
        $from = $request->input('from');
        $to = $request->input('to');
        $search = $request->input('search');
        // dd(isset($from), isset($to));
        if (Gate::allows('admin')) {
            if (isset($search)) {
                $query->search($request->input('search'));
            }
            // dd($query);
            if (isset($from) && isset($to)) {
                $query->fromTo($from, $to);
            } else if (isset($from) && !isset($to)) {
                $query->from($from);
            } else if (!isset($from) && isset($to)) {
                $query->from($to);
            }
            $timesheets = $query->paginate(15)->appends([
                'from' => $from,
                'to' => $to,
                'search' => $search
            ]);
            // dd($timesheets);
            return view('timesheet.index', compact('timesheets'));
        }
        $timesheets = $query->where('user_id', '=', Auth::user()->id)->paginate(15);
        return view('timesheet.employee.index', compact('timesheets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // dd($permissions);
        if (Gate::allows('admin')) {
            $users = User::where('is_admin', 0)->get();
            return view('timesheet.create', compact('users'));
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
        if (!(Auth::user()->is_admin)) {
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

        // admin
        $validated = $request->validate([
            'user' => 'required',
            'check_in' => 'required|date_format:H:i|after:7:30',
            'check_out' => 'required|after:check_in',
            'date' => 'required|unique:timesheets,date'
        ], [
            'check_in.after' => 'Check in field must be after 7:30',
            'check_out.after' => 'Check out field must be after check in',
            'date.unique' => 'You have created this date or user already use this date',
        ]);
        dd($validated);
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
        // Timesheet::create([
        //     'user_id' => $request->
        // ]);
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
        return redirect()->route('timesheet.index')->with('success', 'Timesheet updated successfully');
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
