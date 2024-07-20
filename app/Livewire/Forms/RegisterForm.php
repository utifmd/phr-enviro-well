<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Form;
use Illuminate\Validation\Rules\Password;

class RegisterForm extends Form
{
    public ?User $userModel;

    public ?string $id;
    public ?string $username;
    public ?string $email;
    public ?string $password;
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
        $this->password = $this->userModel->password;
        $this->password_confirmation = $this->userModel->password_confirmation;
    }
}
