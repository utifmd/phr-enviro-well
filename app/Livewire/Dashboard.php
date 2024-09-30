<?php

namespace App\Livewire;

use App\Exports\DashboardExport;
use App\Models\WorkOrder;
use App\Service\IWellService;
use App\Utils\IUtility;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use function Livewire\Volt\title;

class Dashboard extends Component
{
    private ?IWellService $wellService;
    private ?IUtility $utility;

    public string $selectedYearMonth = '';
    public string $year = '';
    public string $month = '';
    public string $selectedMonthName = '';

    public function booted(IWellService $service, IUtility $utility): void
    {
        $this->wellService = $service;
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
        $recapPerMonth = $this->wellService->getRecapPerMonth($this->year, $this->month);
        $userLoadSoFar = $this->wellService->getUserLoadSoFar();

        $colors = ['#8DA2FB', '#0E9F6E', '#F05252', '#FACA15'];
        $pieChartModel = (new PieChartModel())
            ->setTitle('Your VT Load Request Report')
            ->setAnimated(true)
            ->setOpacity(100)
            ->setDataLabelsEnabled(true);

        $columnChartModel = (new ColumnChartModel())
            ->setAnimated(true)
            ->setLegendVisibility(false)
            ->setOpacity(100)
            ->setDataLabelsEnabled(true);

        $i = 0;
        foreach ($userLoadSoFar as $key => $value){
            $title = ucwords(str_replace('_', ' ', $key));
            if ($i != 0) {
                $pieChartModel->addSlice($title, $value, $colors[$i]);
            } else {
                $columnChartModel->addColumn($title, $value, $colors[$i]);
            }
            $i++;
        }
        return view('dashboard', compact(
            'recapPerMonth', 'userLoadSoFar', 'columnChartModel', 'pieChartModel'
        ));
    }
}
