<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoicePaymentRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;


class InvoicePaymentController extends Controller
{

    public function fullPayment($id){
       $invoice = Invoice::findOrFail($id);
       if($invoice->type == 'sales' | $invoice->type =='purchases'){
         $invoice->paid = $invoice->total;
         $invoice->status = 'paid';
         $invoice ->save();
        }
        else {
         return 'this invoice is fully paid';
       }
    }

    public function PartialPayment (InvoicePaymentRequest $request ,$id){
        $invoice = Invoice::findOrFail($id);

        if($invoice->type == 'sales' | $invoice->type =='purchases'){
         $new_paid = $invoice->paid + $request->payment;
         if($new_paid > $invoice->total){
            $remainder = $invoice->total - $invoice->paid;
            return 'warning: you paid '. $invoice->paid .' and the remainder is ' . $remainder;
         }
         else if($new_paid < $invoice->total){
             $invoice->paid = $new_paid;
              $invoice ->save();

         }else{
            $invoice->paid = $invoice->total;
            $invoice->status = 'paid';
             $invoice ->save();
         }
       }
         return new InvoiceResource($invoice);
    }

}
