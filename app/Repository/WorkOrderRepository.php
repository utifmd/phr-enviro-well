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
            $model->well_number = $request['well_number'];
            $model->wbs_number = $request['wbs_number'];
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
        $workOrder->well_number = $model['well_number'];
        $workOrder->wbs_number = $model['wbs_number'];
        $workOrder->is_rig = $model['is_rig'];
        $workOrder->status = $model['status'];
        $workOrder->post_id = $model['post_id'];
        $workOrder->created_at = $model['created_at'];
        $workOrder->updated_at = $model['updated_at'];
        return $workOrder;
    }
}
