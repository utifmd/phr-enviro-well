<?php

namespace App\Repository;

use App\Models\WellMaster;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class WellMasterRepository implements IWellMasterRepository
{
    private ?Builder $builder;

    public function __construct()
    {
        $this->builder = WellMaster::query();
    }

    function pagingWellMaster(?int $page = null): LengthAwarePaginator
    {
        return $this->builder->orderBy('well_number')->paginate();
    }
    function pagingSearchWellMaster(array $params): LengthAwarePaginator
    {
        $builder = $this->builder;
        /*$builder = $builder->whereDate('created_at', '=', Carbon::now());
        $builder->orWhere('ids_wellname', 'ILIKE', '%peTan%');*/
        foreach ($params as $key => $value) {
            $builder->orWhere($key, 'ILIKE', '%'.$value.'%');
        }
        return $builder->paginate();
    }
    public function delete(string $id): bool
    {
        $wellMaster = $this->builder->find($id);
        $isNotExists = $wellMaster->get()->isEmpty();
        if ($isNotExists) return false;

        return $wellMaster->delete();
    }
}
