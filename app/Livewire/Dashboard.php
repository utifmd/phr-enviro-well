<?php

namespace App\Livewire;

use App\Service\IWellService;
use App\Utils\IUtility;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    private IWellService $service;

    public function booted(IWellService $service): void
    {
        $this->service = $service;
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        $loads = $this->service->getCountOfLoadPerMonth(date('Y'), 7);

        return view('dashboard', compact('loads'));
    }
}
