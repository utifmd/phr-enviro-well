<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Policies\UserPolicy;
use App\Repository\IUserRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    private IUserRepository $userRepository;

    public function booted(IUserRepository $userRepository): void
    {
        $this->userRepository = $userRepository;
    }
    #[Layout('layouts.app')]
    public function render(): View
    {
        $users = User::paginate();

        return view('livewire.user.index', compact('users'))
            ->with('i', $this->getPage() * $users->perPage());
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
}
