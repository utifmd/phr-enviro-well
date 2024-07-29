<?php

namespace App\Livewire\Forms;

use App\Models\Post;
use App\Models\UploadedUrl;
use App\Models\User;
use App\Models\WorkOrder;
use App\Repository\IUserRepository;
use Illuminate\Support\Collection;
use Livewire\Form;

class PostForm extends Form
{
    public ?Post $postModel;
    private ?User $user;
    private ?Collection $workOrders;
    private ?Collection $uploadedUrls;

    public $type = '';
    public $title = '';
    public $desc = '';
    public $user_id = '';
    public $loaded_datetime = [];
    public $datetime = '';

    public function booted(IUserRepository $repository): void
    {
        $this->user = $repository->authenticatedUser();
    }

    public function rules(): array
    {
        return [
			'type' => 'required|string',
			'title' => 'string',
			'desc' => 'string',
			'user_id' => 'uuid',
			'datetime' => 'string',
			'loaded_datetime' => 'required',
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
        $this->datetime = $this->postModel->datetime ?? '';
        $this->loaded_datetime = $this->postModel->loaded_datetime ?? [];
        $this->user_id = $this->user->id ?? '';
    }
    public function setResponsePostModel(Post $postModel): void
    {
        $this->setPostModel($postModel);
        $this->workOrders = $postModel->workOrders;
        $this->uploadedUrls = $postModel->uploadedUrls;
        $this->user = $postModel->user;
    }

    public function pushLoadedDatetime(): void
    {
        $this->loaded_datetime[] = $this->datetime;
        $this->reset('datetime');
    }

    public function store(): void
    {
        $this->postModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->postModel->update($this->validate());

        $this->reset();
    }
}
