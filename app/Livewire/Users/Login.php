<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\LoginForm;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Login extends Component
{
    public LoginForm $form;

    public function mount(User $user): void
    {
        $this->form->setUserModel($user);
    }

    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        $this->redirectIntended(
            default: route('dashboard', absolute: false),
            navigate: true
        );
    }

    #[Layout('layouts.guest')]
    public function render(): mixed
    {
        return view('livewire.pages.auth.login');
    }
}
