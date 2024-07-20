<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\RegisterForm;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Register extends Component
{
    public RegisterForm $form;

    public function mount(User $user)
    {
        $this->form->setUserModel($user);
    }

    public function register(): void
    {
        $validated = $this->validate();

        $validated['username'] = explode('@', $validated['email'])[0];
        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);
        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }

    #[Layout('layouts.guest')]
    public function render(): mixed
    {
        return view('livewire.pages.auth.register');
    }
}
