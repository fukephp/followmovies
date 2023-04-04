<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter
{
    /**
     * @var array $safeParms
     */
    protected $safeParms = [];
    /**
     * @var array $columnMap
     */
    protected $columnMap = [];

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function transform(Request $request) {
        $eloQuery = [];
        foreach ($this->safeParms as $parm => $operators) {
            $query = $request->query($parm);

            if (!isset($query)) {
                continue;
            }

            $column = $this->columnMap[$parm] ?? $parm;
            foreach ($operators as $operator) {
                if (isset($query[$operator->value])) {
                    $eloQuery[] = [$column, $operator->toSymbol(), $query[$operator->value]];
                }
            }
        }

        return $eloQuery;
    }

}
