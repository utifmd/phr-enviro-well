<?php

namespace App\Http\Controllers;

use App\Exports\DashboardExport;
use App\Policies\UserPolicy;
use App\Service\IWellService;
use App\Utils\IUtility;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DashboardExportController extends Controller
{
    public function export(
        IWellService $service, IUtility $utility, string $selectedYearMonth): BinaryFileResponse
    {
        Gate::authorize(UserPolicy::IS_PHR_ROLE);
        $filename = 'daily-report-phr-' . $selectedYearMonth . '.xlsx'; /*date('YmdHis')*/

        $dashboardExport = new DashboardExport(
            $service, $utility, $selectedYearMonth
        );
        return Excel::download($dashboardExport, $filename);
    }

    public function sheetExport(): BinaryFileResponse
    {
        return Excel::create('New file', function($excel) {

            $excel->sheet('New sheet', function($sheet) {

                $sheet->loadView('dashboard');

            });

        });
    }
}
