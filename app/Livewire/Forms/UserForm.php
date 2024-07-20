<?php

namespace App\Livewire\Forms;

use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $userModel;

    public ?string $id;
    public ?string $username;
    public ?string $email;
    public ?string $password;
    public ?string $created_at;
    public ?string $updated_at;
    public ?string $password_confirmation;

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'. User::class],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
            'username' => ['string', 'max:255']
        ];
    }

    public function setUserModel(User $userModel): void
    {
        $this->userModel = $userModel;

        $this->email = $this->userModel->email;
        $this->username = $this->userModel->username ?? "";
    }

    public function setUserRequestModel(User $userModel): void
    {
        $this->setUserModel($userModel);

        $this->password = $this->userModel->password;
        $this->password_confirmation = $this->userModel->password_confirmation;
    }

    public function setUserResponseModel(User $userModel): void
    {
        $this->setUserModel($userModel);
        $this->id = $userModel->id;
        $this->created_at = $userModel->created_at;
        $this->updated_at = $userModel->updated_at;
    }

    public function store(): void
    {
        $this->userModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->userModel->update($this->validate());

        $this->reset();
    }
}
