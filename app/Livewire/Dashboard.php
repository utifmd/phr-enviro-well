<?php

namespace App\Livewire;

use App\Models\WorkOrder;
use App\Service\IWellService;
use App\Utils\IUtility;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    private IWellService $service;
    private IUtility $utility;

    public string $selectedYearMonth = '';
    public string $selectedYear = '';
    public string $selectedMonth = '';
    public string $selectedMonthName = '';

    public function booted(IWellService $service, IUtility $utility): void
    {
        $this->service = $service;
        $this->utility = $utility;
        $this->selectedMonthName = $utility->nameOfMonth($this->selectedMonth);
    }

    public function mount(): void
    {
        $this->selectedYearMonth = date('Y-m');
        if ($storedYearMonth = Session::get(WorkOrder::WORK_ORDER_NAME)){
            $this->selectedYearMonth = $storedYearMonth;
        }
        $this->setBranchedProps();
    }
    private function setBranchedProps(): void
    {
        $separatedDates = explode('-', $this->selectedYearMonth);
        $this->selectedYear = $separatedDates[0];
        $this->selectedMonth = $separatedDates[1];

        Session::put(WorkOrder::WORK_ORDER_NAME, $this->selectedYearMonth);
        Session::save();
    }
    public function apply(): void
    {
        $this->setBranchedProps();
        $this->selectedMonthName = $this->utility->nameOfMonth($this->selectedMonth);
        $this->service->getCountOfLoadPerMonth($this->selectedYear,$this->selectedMonth);
    }

    #[Layout('layouts.app')]
    public function render(): View
    {
        $loads = $this->service->getCountOfLoadPerMonth($this->selectedYear,$this->selectedMonth);

        return view('dashboard', compact('loads'));
    }
}
