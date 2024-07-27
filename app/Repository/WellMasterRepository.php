<?php

namespace App\Repository;

use App\Models\WellMaster;
use Illuminate\Pagination\LengthAwarePaginator;

class WellMasterRepository implements IWellMasterRepository
{
    function pagingWellMaster(?int $page = null): LengthAwarePaginator
    {
        return WellMaster::query()->paginate();
    }
    function pagingSearchWellMaster(array $params): LengthAwarePaginator
    {
        $builder = WellMaster::query();
        /*$builder = $builder->whereDate('created_at', '=', Carbon::now());
        $builder->orWhere('ids_wellname', 'ILIKE', '%peTan%');*/
        foreach ($params as $key => $value) {
            $builder->orWhere($key, 'ILIKE', '%'.$value.'%');
        }
        return $builder->paginate();
    }
}
