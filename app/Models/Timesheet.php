<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Query\JoinClause;

class Timesheet extends Model
{
    use HasFactory;
    protected $fillable = ['check_in', 'check_out', 'date', 'check_in_status', 'check_out_status', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $search = '') {
        return $query->join('users', function(JoinClause $join) use ($search)  {
            $join->on('timesheets.user_id', '=', 'users.id')
                 ->where('users.name', 'LIKE', '%'.$search.'%');
        });
    }

    public function scopeFrom($query, $from = '') {
        return $query->where('date', '>', $from);
    }

    public function scopeFromTo($query, $from = '', $to = '') {
        return $query->whereBetween('date', [$from, $to]);
    }
}
