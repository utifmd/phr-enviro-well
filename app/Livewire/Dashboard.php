<?php

namespace App\Livewire;

use App\Exports\DashboardExport;
use App\Models\WorkOrder;
use App\Service\IWellService;
use App\Utils\IUtility;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Dashboard extends Component
{
    private ?IWellService $service;
    private ?IUtility $utility;

    public string $selectedYearMonth = '';
    public string $year = '';
    public string $month = '';
    public string $selectedMonthName = '';

    public function booted(IWellService $service, IUtility $utility): void
    {
        $this->service = $service;
        $this->utility = $utility;
        $this->selectedMonthName = $utility->nameOfMonth($this->month);
    }

    public function mount(): void
    {
        $this->selectedYearMonth = date('Y-m');
        if ($storedYearMonth = Session::get(WorkOrder::SELECTED_YEAR_MONTH_NAME)){
            $this->selectedYearMonth = $storedYearMonth;
        }
        $this->onSelectedYearMonthChange();
    }
    public function onSelectedYearMonthChange(): void
    {
        $separatedDates = explode('-', $this->selectedYearMonth);
        $this->year = $separatedDates[0];
        $this->month = $separatedDates[1];

        if (isset($this->utility))
            $this->selectedMonthName = $this->utility->nameOfMonth($this->month);

        $this->storePropsSession();
    }
    private function storePropsSession(): void
    {
        Session::put(WorkOrder::SELECTED_YEAR_MONTH_NAME, $this->selectedYearMonth);
        Session::save();
    }
    #[Layout('layouts.app')]
    public function render(): View
    {
        $loads = $this->service->getCountOfLoadPerMonth($this->year,$this->month);

        return view('dashboard', compact('loads'));
    }
}
