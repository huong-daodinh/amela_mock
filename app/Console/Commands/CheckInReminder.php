<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\Reminder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;

class CheckInReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-in-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
    */
    public function handle()
    {
        $users = User::query()->where('is_admin', '0')
        ->leftJoin('timesheets', function($leftJoin) {
            $leftJoin->on('users.id', '=', 'timesheets.user_id')
            ->whereNull('timesheets.id');
        })->get();
        // dd($users);
        foreach($users as $user) {
            Mail::to($user->email)->queue(new Reminder($user->name));
        }

        return 0;
    }
}
