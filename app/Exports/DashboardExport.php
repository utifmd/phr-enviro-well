<?php

namespace App\Exports;

use App\Service\IWellService;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DashboardExport implements FromView
{
    private ?IWellService $service;
    private ?string $year;
    private ?string $month;

    public function __construct(
        IWellService $service, string $selectedYearMonth)
    {
        $selections = explode('-', $selectedYearMonth);

        $this->service = $service;
        $this->year = $selections[0];
        $this->month = $selections[1];
    }
    /**
     * @inheritDoc
     */
    public function view(): View
    {
        $loads = $this->service->getCountOfLoadPerMonth($this->year, $this->month);
        return view('components.table-dashboard', compact('loads'));
    }
}
