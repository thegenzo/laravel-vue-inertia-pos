<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Profit;
use App\Exports\ProfitsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ProfitController extends Controller
{
    public function index()
    {
        return Inertia::render('Apps/Profits/Index');
    }

    public function filter(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        // get data profits within range
        $profits = Profit::with('transaction')->whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->get();

        // get total profits
        $total = $profits->sum('total');

        return Inertia::render('Apps/Profits/Index', [
            'profits' => $profits,
            'total' => $total
        ]);
    }

    public function export(Request $request)
    {
        return Excel::download(new ProfitsExport($request->start_date, $request->end_date), 'profits: ' . $request->start_date . ' - ' . $request->end_date . '.xlsx');
    }

    public function pdf(Request $request)
    {
        // get data profits within range
        $profits = Profit::with('transaction')->whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->get();

        // get total profits
        $total = $profits->sum('total');

        // load PDF with data
        $pdf = PDF::loadView('exports.profits', compact('profits', 'total'));

        // return PDF for preview / download
        return $pdf->download('profits : ' . $request->start_date . ' - ' . $request->end_date . '.pdf');
    }


}
