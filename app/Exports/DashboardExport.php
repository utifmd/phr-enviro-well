<?php

namespace App\Exports;

use App\Service\IWellService;
use App\Utils\IUtility;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\{FromView, ShouldAutoSize, WithStyles};
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\{Alignment, Border, Fill, Color};

class DashboardExport implements FromView, WithStyles, ShouldAutoSize
{
    private ?IWellService $service;
    private ?IUtility $utility;
    private ?string $year;
    private ?string $month;
    const HORIZONTAL_RANGE = 'A1:AI';

    public function __construct(
        IWellService $service, IUtility $utility, string $selectedYearMonth)
    {
        $separatedDates = explode('-', $selectedYearMonth);

        $this->service = $service;
        $this->utility = $utility;
        $this->year = $separatedDates[0];
        $this->month = $separatedDates[1];
    }
    /**
     * @inheritDoc
     */
    public function view(): View
    {
        $loads = $this->service->getRecapPerMonth($this->year, $this->month);
        $data = [
            'loads' => $loads,
            'year' => $this->year,
            'selectedMonthName' => $this->utility->nameOfMonth($this->month),
        ];
        return view('components.table-dashboard', $data);
    }

    public function styles(Worksheet $sheet): void
    {
        $highestRowAndColumn = $sheet->getHighestRowAndColumn();

        $highestRow = $highestRowAndColumn['row']; //'column'
        $dashboardCoordinate = self::HORIZONTAL_RANGE . $highestRow;
        $dashboard = $sheet->getStyle($dashboardCoordinate);

        $dashboard->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setWrapText(true);
        try {
            $dashboard->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);
        } catch (Exception $e) {

            Log::debug($e->getMessage());
        }
        $header = $sheet->getStyle(self::HORIZONTAL_RANGE.'2');

        $header->getFont()
            ->setBold(true);

        $header->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->setStartColor(new Color('BDD7EE'));
    }
}
