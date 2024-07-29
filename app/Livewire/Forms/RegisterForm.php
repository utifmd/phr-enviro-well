<?php

namespace App\Livewire\Forms;

use App\Models\User;
use App\Repository\IUserRepository;
use App\Utils\Enums\UserRoleEnum;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Form;

class RegisterForm extends Form
{
    public ?User $userModel;
    private IUserRepository $userRepository;

    public ?string $id;
    public ?string $username;
    public ?string $email;
    public ?string $password;
    public ?string $role;
    public ?string $password_confirmation;

    public function boot(IUserRepository $repository): void
    {
        $this->userRepository = $repository;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'. User::class],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
            'username' => ['string', 'max:255'],
            'role' => ['string']
        ];
    }
    public function setUserModel(User $userModel): void
    {
        $this->userModel = $userModel;

        $this->email = $this->userModel->email;
        $this->username = $this->userModel->username ?? "";
        $this->role = $this->userModel->role ?? "";
        $this->password = $this->userModel->password;
        $this->password_confirmation = $this->userModel->password_confirmation;
    }

    public function submit(): void
    {
        $this->role = UserRoleEnum::USER_GUEST_ROLE->value;
        $this->username = explode('@', $this->email)[0];
        $this->password = Hash::make($this->password);

        $this->userRepository->register($this->all());
    }
}
