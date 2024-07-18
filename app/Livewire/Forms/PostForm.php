<?php

namespace App\Livewire\Forms;

use App\Models\Post;
use Livewire\Form;

class PostForm extends Form
{
    public ?Post $postModel;
    
    public $type = '';
    public $title = '';
    public $desc = '';
    public $user_id = '';

    public function rules(): array
    {
        return [
			'type' => 'required|string',
			'title' => 'string',
			'desc' => 'string',
			'user_id' => 'uuid',
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
