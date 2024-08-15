<?php

namespace App\Livewire\Forms;

use App\Utils\Enums\UserRoleEnum;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $userModel;

    public ?string $id;
    public ?string $username;
    public ?string $role;
    public ?string $email;
    public ?string $password;
    public ?string $created_at;
    public ?string $updated_at;
    public ?string $password_confirmation;

    public bool $isUpdating = false;
    public bool $isNewPassword = false;

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'. User::class],
            'password' => ['required', 'string', Password::defaults()],
            'username' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string']
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

        $this->role = $this->userModel->role ?? UserRoleEnum::USER_GUEST_ROLE->value;
        $this->password = $this->userModel->password;
        // $this->password_confirmation = $this->userModel->password_confirmation;
    }

    public function setUserResponseModel(User $userModel): void
    {
        $this->setUserModel($userModel);
        $this->id = $userModel->id;
        $this->role = $userModel->role;
        $this->created_at = $userModel->created_at;
        $this->updated_at = $userModel->updated_at;
    }

    public function store(\Closure $onComplete): void
    {
        $validatedRequest = $this->validate();
        $onComplete($validatedRequest);
        //$this->userModel->create($this->validate());
        $this->reset();
    }

    public function update(\Closure $onComplete): void
    {
        $rules = $this->rules();
        $rules['email'] = ['required', 'string', 'lowercase', 'email', 'max:255'];

        if (!$this->isNewPassword) {
            $this->password = null;
            unset($rules['password']);
        }
        // $this->userModel->update($this->validate($rules));
        $onComplete($this->validate($rules));
        // $this->reset();
    }
}
