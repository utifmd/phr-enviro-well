<?php

namespace App\Http\Controllers;

use App\Exports\DashboardExport;
use App\Policies\UserPolicy;
use App\Service\IWellService;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DashboardExportController extends Controller
{
    public function export(IWellService $service, string $selectedYearMonth): BinaryFileResponse
    {
        Gate::authorize(UserPolicy::IS_PHR_ROLE);
        $filename = 'daily-report-phr-' . $selectedYearMonth . '.xlsx'; /*date('YmdHis')*/

        return Excel::download(new DashboardExport($service, $selectedYearMonth), $filename);
    }
}
