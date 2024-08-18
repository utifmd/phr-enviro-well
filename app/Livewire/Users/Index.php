<?php

namespace App\Livewire\Users;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Repository\IUserRepository;
use App\Utils\Enums\UserRoleEnum;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    private IUserRepository $userRepository;
    public string $role;

    public function booted(IUserRepository $userRepository): void
    {
        $this->userRepository = $userRepository;
    }

    public function mount(User $user): void
    {
        $this->role = $user->role ?? '';
    }

    public function onRoleChange(): void
    {
        if ($this->role == "") {
            $this->userRepository->pagedUsers();
            return;
        }
        $this->validate(['role' => 'required|string|min:3']);
        $this->userRepository->pagedUsersByRole($this->role);
    }

    public function delete(string $userId): void
    {
        $this->authorize(UserPolicy::IS_DEV_ROLE);
        $isDeleted = $this->userRepository->delete($userId);

        if (!$isDeleted) {
            Log::debug('delete failed at userId: '.$userId);
            return;
        }
        $this->redirectRoute('users.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        $users = $this->userRepository->pagedUsers();

        return view('livewire.user.index', compact('users'))
            ->with('i', round($this->getPage() * $users->perPage()));
    }
}
