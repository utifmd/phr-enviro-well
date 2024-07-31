<?php

namespace App\Repository;

use App\Models\WorkOrder;
use App\Repository\IWorkOrderRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class WorkOrderRepository implements IWorkOrderRepository
{
    function addWorkOrder(array $request): ?WorkOrder
    {
        $createdPost = WorkOrder::query()->create($request);
        $post = $this->fromBuilderOrModel($createdPost);

        if (is_null($post->id)) return null;
        return $post;
    }

    function getWorkOrderById(string $post_id): Collection
    {
        $builder = WorkOrder::query()->where(
            'post_id', '=', $post_id
        );
        return $builder->get();
    }
    public function getWorkOrderLoadBy(string $year, int $month, string $idsWellName): Collection
    {
        $builder = WorkOrder::query()
            ->selectRaw(
                'ids_wellname,
                 DATE_PART(\'day\', created_at) AS day,
                 COUNT(created_at) AS count')
            ->whereRaw(
                'DATE_PART(\'year\', created_at) = \''. $year. '\' AND
                 DATE_PART(\'month\', created_at) = \''. $month. '\' AND
                 ids_wellname = \''.$idsWellName.'\'')
            ->groupByRaw(
                'DATE_PART(\'day\', created_at),
                 ids_wellname');

        /*$builder = WorkOrder::query()
            ->selectRaw($columns)
            ->whereRaw('DATE_PART(\'month\', created_at) = \''. $month. '\' AND well_master_id = \''.$wellMasterId.'\'')
            ->groupByRaw('DATE_PART(\'day\', created_at), well_master_id');*/

        return $builder->get();
    }
    public function getWorkOrderNameByMonth(string $year, int $month): Collection
    {
        $builder = WorkOrder::query()
            ->select([
                'work_orders.ids_wellname', 'well_masters.wbs_number']) // CONCAT(work_orders.ids_wellname, '(', work_orders.ids_wellname, ')')
            ->leftJoin('well_masters',
                'well_masters.ids_wellname', '=', 'work_orders.ids_wellname')
            ->whereRaw(
                'DATE_PART(\'year\', work_orders.created_at) = \'' . $year . '\' AND
                 DATE_PART(\'month\', work_orders.created_at) = \'' . $month . '\'')
            ->groupByRaw(
                'DATE_PART(\'month\', work_orders.created_at),
                 work_orders.ids_wellname,
                  well_masters.wbs_number');

        /*$builder = WorkOrder::query()
            ->select(['well_masters.id', 'well_masters.ids_wellname', 'well_masters.wbs_number'])
            ->leftJoin('well_masters', 'well_masters.id', '=', 'work_orders.well_master_id')
            ->whereRaw('DATE_PART(\'month\', work_orders.created_at) = \'' . $month . '\'')
            ->groupByRaw('DATE_PART(\'month\', work_orders.created_at), well_masters.id, well_masters.ids_wellname, well_masters.wbs_number');*/

        return $builder->get()/*->sortByDesc(function ($wo, $key){
            return $wo['created_at'];
        })*/;
    }

    function searchWorkOrderByWell(
        string $wellNumber, ?string $wbsNumber, ?string $createdDate, ?string $createdTime): Collection
    {
        $builder = WorkOrder::query();
        $builder
            ->where('well_number', 'LIKE', '%'. $wellNumber .'%')
            ->orWhere('wbs_number', 'LIKE', '%'. $wellNumber .'%');

        if (!is_null($createdDate)) {
            $builder->whereDate('created_at', '=', $createdDate); // $builder->whereDate('created_at', Carbon::today());
        }
        if (!is_null($createdTime)) {
            $builder->whereTime('created_at', '=', $createdTime);
        }
        return $builder->get();
    }

    function updateWorkOrder(string $workOrderId, array $request): ?WorkOrder
    {
        try {
            $model = WorkOrder::query()->find($workOrderId);
            $model->shift = $request['shift'];
            $model->is_rig = $request['is_rig'];
            $model->status = $request['status'];

            if(!$model->save()) return null;
            return $model
                ->get()
                ->first();

        } catch (\Throwable $t){
            Log::error($t->getMessage());
            return null;
        }
    }

    function removeWorkOrder(string $workOrderId): bool
    {
        try {
            $model = WorkOrder::query()->find($workOrderId);
            return $model->delete();
        } catch (\Throwable $t) {
            Log::error($t->getMessage());
            return false;
        }
    }

    private function fromBuilderOrModel(Model|Builder $model): WorkOrder
    {
        $workOrder = new WorkOrder();
        $workOrder->id = $model['id'];
        $workOrder->shift = $model['shift'];
        $workOrder->is_rig = $model['is_rig'];
        $workOrder->status = $model['status'];
        $workOrder->well_master_id = $model['well_master_id'];
        $workOrder->post_id = $model['post_id'];
        $workOrder->created_at = $model['created_at'];
        $workOrder->updated_at = $model['updated_at'];
        return $workOrder;
    }
}
