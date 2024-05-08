<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Timesheet extends Model
{
    use HasFactory;
    protected $fillable = ['check_in', 'check_out', 'date', 'check_in_status', 'check_out_status'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
