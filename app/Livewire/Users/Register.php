<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\RegisterForm;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Register extends Component
{
    public RegisterForm $form;

    public function mount(User $user): void
    {
        $this->form->setUserModel($user);
    }

    public function register(): void
    {
        $this->validate();
        $this->form->submit();
        $this->redirect(
            route('dashboard', absolute: false),
            navigate: true
        );
    }

    #[Layout('layouts.guest')]
    public function render(): mixed
    {
        return view('livewire.pages.auth.register');
    }
}
