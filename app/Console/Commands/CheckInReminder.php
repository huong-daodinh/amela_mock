<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\Reminder;

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
        $users = User::query()->where('is_admin', '0');
        foreach($users as $user) {
            Mail::to($user->email)->send(new Reminder($user));
        }

        return 0;
    }
}
