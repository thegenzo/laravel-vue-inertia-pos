<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Transaction;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    public function index()
    {
        return Inertia::render('Apps/Sales/Index');
    }

    public function filter(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        // get data sales by range date
        $sales = Transaction::with('cashier', 'customer')
                    ->whereDate('created_at', '>=', $request->start_date)
                    ->whereDate('created_at', '<=', $request->end_date)
                    ->get();

        // get total sales by range date
        $total = $sales->sum('grand_total');

        return Inertia::render('Apps/Sales/Index', [
            'sales' => $sales,
            'total' => $total
        ]);
    }

    public function export(Request $request)
    {
        return Excel::download(new SalesExport($request->start_date, $request->end_date), 'sales : '.$request->start_date. ' - '. $request->end_date. '.xlsx');
    }

    public function pdf(Request $request)
    {
        // get sales by range date
        $sales = Transaction::with('cashier', 'customer')->whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->get();

        // get total sales by range date
        $total = Transaction::whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->sum('grand_total');

        // load view PDF with data
        $pdf = PDF::loadView('exports.sales', compact('sales', 'total'));

        // return PDF for preview / download
        return $pdf->download('sales : ' . $request->start_date . ' - ' . $request->end_date . '.pdf');
    }
}
