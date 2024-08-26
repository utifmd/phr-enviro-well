<?php

namespace App\Repository;

use Illuminate\Pagination\LengthAwarePaginator;

interface IWellMasterRepository
{
    function pagingWellMaster(?int $page): LengthAwarePaginator;
    function pagingSearchWellMaster(array $params): LengthAwarePaginator;
    function delete(string $id): bool;
}
