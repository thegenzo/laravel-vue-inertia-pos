<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SalesExport implements FromView
{
    protected $start_date; 
    protected $end_date;
    
    public function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.sales', [
            'sales' => Transaction::with('cashier', 'customer')->whereDate('created_at', '>=', $this->start_date)->whereDate('created_at', '<=', $this->end_date)->get(),
            'total' => Transaction::whereDate('created_at', '>=', $this->start_date)->whereDate('created_at', '<=', $this->end_date)->sum('grand_total')
        ]);
    }
}
