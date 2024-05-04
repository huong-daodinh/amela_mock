<?php

namespace App\Filters\v1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class DepartmentFilter extends ApiFilter {
    protected $allowParm = [
        'name' => ['eq'],
    ];
    protected $realCol = [];
}
