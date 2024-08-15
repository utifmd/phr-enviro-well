<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use App\Repository\IUserRepository;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    private IUserRepository $userRepository;
    public UserForm $form;

    public function mount(User $user)
    {
        $this->form->isNewPassword = true;
        $this->form->setUserRequestModel($user);
    }

    public function booted(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function save()
    {
        $this->form->store(function (array $request) {
            try {
                $this->userRepository->create($request);
                $this->redirectRoute('users.index', navigate: true);

            } catch (\Throwable $throwable){
                Log::debug($throwable->getMessage());
                $this->form->addError('email', 'Email or username has been taken.');
            }
        });
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.user.create');
    }
}
