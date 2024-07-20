<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Login extends Component
{
    public UserForm $form;

    public function mount(User $user)
    {
        Log::debug('mounted: user '. $user);
        $this->form->setUserModel($user);
    }

    public function login(): void
    {
        $validateArr = $this->validate();

        Log::debug('Array > '. json_encode($validateArr));

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(
            default: route(
                'dashboard', absolute: false
            ),
            navigate: true
        );
    }

    #[Layout('layouts.guest')]
    public function render(): mixed
    {
        return view('livewire.pages.auth.login');
    }
}
