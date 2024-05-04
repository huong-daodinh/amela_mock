<?php
namespace App\Filters\v1;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class UserFilter extends ApiFilter{
    protected $allowParm = [
        'id' => ['eq'],
        'name' => ['eq', 'lk'],
        'email' => ['eq', 'lk'],
        'dateOfBirth' => ['eq', 'lt', 'gt'],
        'department' => ['eq'],
    ];

    protected $realCol = [
        'dateOfBirth' => 'date_of_birth',
    ];


}

