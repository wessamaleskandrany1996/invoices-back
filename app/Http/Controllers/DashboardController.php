<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvoiceResource;
use App\Models\Customer;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

     public function dashboard(){

        // today  total clients
        $customers = Customer::whereDate('created_at', Carbon::today())->get();
        $countCustomers = count($customers);
        // today total invoices
        $invoices = Invoice::whereDate('created_at' , Carbon::today())->where('type','sales')->get();
        $countInvoices = count($invoices);
        // today total balance
           $totalbalance=0;
        foreach($invoices as $invoice){
         $totalbalance += $invoice->paid;
        }
        // total purchase debt
         $totalDebt = 0;
        $purchaseInvoices = Invoice::where(['type'=>'purchases','status'=>'postponed'])->get();
        foreach($purchaseInvoices as $invoice){
            $invoiceDebt = $invoice->total-$invoice->paid;
            $totalDebt += $invoiceDebt;

        };

        return [
            'total_clients' => $countCustomers,
            'total_sales_invoices' =>$countInvoices,
            'total_balance'=>$totalbalance,
            'total_debt'=>$totalDebt
        ];
    }
    public function lastInvoices(){
         $salesInvoices = Invoice::whereDate('created_at' , Carbon::today())->where('type','sales')->get();
         return InvoiceResource::collection($salesInvoices);
    }
}
