<?php

namespace App\Livewire\Forms;

use App\Models\Post;
use App\Models\WellMaster;
use App\Utils\Enums\WorkOrderShiftEnum;
use App\Utils\Enums\WorkOrderStatusEnum;
use Illuminate\Support\Facades\Session;
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

            'datetime' => 'string',
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

    public function setRequestPostModel(Post $postModel): void
    {
        $this->setPostModel($postModel);
        $this->user_id = $this->postModel->user_id ?? '';

        $this->is_rig = $this->postModel->is_rig ?? true;
        $this->ids_wellname = $this->postModel->ids_wellname ?? '';
        $this->shift = $this->postModel->shift ?? WorkOrderShiftEnum::DAY->value;

        $this->datetime = $this->postModel->datetime ?? '';
        $this->loaded_datetime = $this->postModel->loaded_datetime ?? [];
    }
    public function setResponsePostModel(Post $postModel): void
    {
        $this->setPostModel($postModel);
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

    public function store(\Closure $addNewWell): void
    {
        $this->validate();

        $post = [
            'type' => $this->type,
            'title' => $this->title,
            'desc' => $this->desc,
            'user_id' => $this->user_id,
        ];
        $uploadedUrl = [
            'url' => 'https://via.placeholder.com/150',
            'path' => './public/images/upload/150.png'
        ];
        $workOrders = [];
        $workOrder = [
            'shift' => $this->shift,
            'is_rig' => $this->is_rig,
            'status' => WorkOrderStatusEnum::STATUS_SENT->value,
            'ids_wellname' => $this->ids_wellname
        ];
        foreach ($this->loaded_datetime as $load) {
            $workOrder['created_at'] = $load;
            $workOrders[] = $workOrder;
        }
        $addNewWell($post, $uploadedUrl, $workOrders);
        $this->reset();
    }

    public function update(): void
    {
        $this->postModel->update($this->validate());
        $this->reset();
    }
}
