<?php

namespace App\Livewire\Forms;

use App\Models\Post;
use App\Utils\Enums\WorkOrderShiftEnum;
use App\Utils\Enums\WorkOrderStatusEnum;
use Illuminate\Support\Facades\Log;
use Livewire\Form;

class PostForm extends Form
{
    public ?Post $postModel;

    public $type = '';
    public $title = '';
    public $desc = '';
    public $user_id = '';

    public $is_rig = false;
    public $ids_wellname = '';
    public $shift = '';

    public $uploadedUrls = [];
    public $workOrders = [];

    public $loaded_datetime = [];
    public $datetime = '';

    public function rules(): array
    {
        return [
			'type' => 'required|string',
			'title' => 'string',
			'desc' => 'string',
			'user_id' => 'uuid',

            'is_rig' => 'required|boolean',
            'ids_wellname' => 'required|string',
            'shift' => 'required|string',

            'loaded_datetime' => 'required|array',
        ];
    }

    public function setPostModel(Post $postModel): void
    {
        $this->postModel = $postModel;

        $this->type = $this->postModel->type;
        $this->title = $this->postModel->title;
        $this->desc = $this->postModel->desc;
        $this->user_id = $this->postModel->user_id;
    }

    public function setRequestCreatePostModel(Post $postModel): void
    {
        $this->setPostModel($postModel);
        $this->user_id = $this->postModel->user_id ?? '';

        $this->ids_wellname = $this->postModel->ids_wellname ?? '';
        $this->is_rig = $this->postModel->is_rig ?? true;
        $this->shift = $this->postModel->shift ?? WorkOrderShiftEnum::DAY->value;

        $this->datetime = $this->postModel->datetime ?? '';
        $this->loaded_datetime = $this->postModel->loaded_datetime ?? [];
    }

    public function setRequestUpdatePostModel(Post $postModel): void
    {
        $this->setPostModel($postModel);
        $this->user_id = $this->postModel->user_id ?? '';

        $this->ids_wellname = $this->postModel->ids_wellname ?? $this->postModel->title ?? '';
        $this->is_rig = $this->postModel->workOrders[0]['is_rig'] ?? true;
        $this->shift = $this->postModel->workOrders[0]['shift'] ?? WorkOrderShiftEnum::DAY->value;
        $this->uploadedUrls = $this->postModel->uploadedUrls->toArray() ?? [];
        $this->workOrders = $this->postModel->workOrders->toArray() ?? [];

        $this->datetime = $this->postModel->datetime ?? '';
        $this->loaded_datetime = $this->postModel->loaded_datetime ??
            collect($this->workOrders)->map(function ($wo){ return $wo['created_at']; });
    }
    public function setResponsePostModel(Post $postModel): void
    {
        $this->setPostModel($postModel);
        $this->user_id = $this->postModel->user_id ?? '';

        $this->ids_wellname = $this->postModel->ids_wellname ?? '';
        $this->workOrders = $this->postModel->workOrders ?? [];

        $this->is_rig = $this->postModel->workOrders[0]['is_rig'] ?? true;
        $this->shift = $this->postModel->workOrders[0]['shift'] ?? WorkOrderShiftEnum::DAY->value;
        $this->uploadedUrls = $this->postModel->uploadedUrls->toArray() ?? [];

        $this->datetime = $this->postModel->datetime ?? '';
        $this->loaded_datetime = $this->postModel->loaded_datetime ??
            collect($this->postModel->workOrders)->map(function ($load) { return $load['created_at']; });

        $this->desc = str_replace(';', ' ', $this->postModel->desc);
        Log::debug('desc: '. $this->desc);
        $this->workOrders = collect($this->workOrders)->sortBy('created_at')->values()->all();
    }

    public function pushLoadedDatetime(): void
    {
        if ($this->datetime == '') return;

        $this->loaded_datetime[] = $this->datetime;
        $this->reset('datetime');
    }

    public function filteredLoadedDatetimeAt(int $i): void
    {
        if (!$this->loaded_datetime[$i]) return;
        unset($this->loaded_datetime[$i]);
    }

    public function store(\Closure $onComplete): void
    {
        $this->validate();
        $this->submit($onComplete);
    }

    public function edit(\Closure $onComplete): void
    {
        $this->validate([
            'loaded_datetime' => 'required|array',
            'uploadedUrls' => 'required|array'
        ]);
        $this->submit($onComplete);
    }

    private function submit(\Closure $onComplete): void
    {
        $post = [
            'type' => $this->type,
            'title' => $this->title,
            'desc' => $this->desc,
            'user_id' => $this->user_id,
        ];
        $uploadedUrl = $this->uploadedUrls[0] ?? [];
        $workOrders = [];
        $workOrder = [
            'shift' => $this->shift,
            'is_rig' => $this->is_rig,
            'status' => WorkOrderStatusEnum::STATUS_PENDING->value,
            'ids_wellname' => $this->ids_wellname ?: $this->title
        ];
        foreach ($this->loaded_datetime as $load) {
            $workOrder['created_at'] = $load;
            $workOrders[] = $workOrder;
        }
        $onComplete($post, $uploadedUrl, $workOrders);
        $this->reset();
    }

    public function onRemoveEvidences(\Closure $onComplete): void
    {
        $paths = [];
        foreach ($this->uploadedUrls as $uploadedUrl) {
            $paths[] = $uploadedUrl['path'];
        }
        $onComplete($paths);
    }

    public function onUpdateWorkOrders(\Closure $onComplete): void
    {
        $onComplete();
        $this->reset();
    }

    public function onChangeStateOfWorkOrder(string $woId, array $request): array
    {
        foreach ($this->workOrders as $workOrder) {
            if($workOrder['id'] != $woId) continue;

            $workOrder['status'] = $request['status'];
        }
        return $this->workOrders;
    }

    public function update(): void
    {
        $this->postModel->update($this->validate());
        $this->reset();
    }
}
