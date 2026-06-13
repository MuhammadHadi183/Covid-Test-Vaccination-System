<?php

namespace App\Http\Controllers;

use App\Exports\MedTrackExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    
    public function exportExcel()
    {
        return Excel::download(new MedTrackExport, 'MedTrack Pro Data.xlsx');
    }
}
