<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Http\Resources\InvoiceResource;

use App\Models\Invoice;
use Illuminate\Http\Request;


class InvoiceController extends Controller
{

    public function index()
    {
        $invoice = Invoice::paginate(15);
        return InvoiceResource::collection($invoice);
    }

    public function store(InvoiceRequest $request)
    {
        $invoice = new Invoice([
            'code' => $request->code,
            'total' => $request->total,
            'paid' => $request->paid,
            'status' => $request->status,
            'type' => $request->type

        ]);
        $invoice->save();
        return  new InvoiceResource($invoice);
    }


    public function show(Invoice $invoice)
    {
        return  new InvoiceResource($invoice);
    }
    public function filter($type)
    {

        $invoices = Invoice::paginate(15);
        $filtered = $invoices->where('type', $type);
        $filtered->all();
        return InvoiceResource::collection($filtered);
    }
    public function postponedInvoices(Request $request)
    {
        if( $request->has('status') && $request->has('status') == 'postponed'){

         if($request->input('type') == 'purchases'){

               $invoices = Invoice::where(['type'=>'purchases','status'=>'postponed'])->paginate(15);
               return InvoiceResource::collection($invoices);
             }
             else if($request->input('type') == 'sales') {

                 $invoices = Invoice::where(['type'=>'sales','status'=>'postponed'])->paginate(15);
               return InvoiceResource::collection($invoices);
             }else{
                return "incorrect invoice type";
             }
        }
    }

    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        $invoice->code = $request->code;
        $invoice->total = $request->total;
        $invoice->paid = $request->paid;
        $invoice->status = $request->status;
        $invoice->type = $request->type;
        $invoice->save();
        return  new InvoiceResource($invoice);
    }


    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return response()->json(
            [
                'error' => false,
                'message' => " the invoice with  $invoice->id is deleted successfully"
            ],
            200
        );
    }

}
