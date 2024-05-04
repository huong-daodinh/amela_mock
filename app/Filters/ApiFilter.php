<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter {
    protected $allowParm = [];

    protected $realCol = [];

    protected $operators = [
        'lk' => 'like',
        'eq' => '=',
        'lt' => '<',
        'gt' => '>',
    ];

    public function transform(Request $request) {
        $eloQuery = [];
        foreach($this->allowParm as $parm => $operators) {
            $query = $request->query($parm);
            // dd($query);
            if (!isset($query)) {
                continue;
            }
            $column = $this->realCol[$parm] ?? $parm;
            foreach($operators as $operator) {
                // dd($operator);
                // dd($this->operators[$operator]);
                if (isset($query[$operator])) {
                    if ($operator == 'lk') {
                        $query[$operator] = '%'.$query[$operator].'%';
                    }
                    $eloQuery[] = [$column, $this->operators[$operator] ,$query[$operator]];
                }
            }
        }
        return $eloQuery;
    }
}
