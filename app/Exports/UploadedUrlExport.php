<?php

namespace App\Exports;

use App\Models\UploadedUrl;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class UploadedUrlExport implements FromCollection
{
    public function collection(): Collection
    {
        return UploadedUrl::all();
    }
}
