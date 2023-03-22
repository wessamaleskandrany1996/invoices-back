<?php

namespace App\Http\Controllers\api;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseInvoicesRequest;

class PurchaseInvoiceController extends Controller
{
    public function purchaseInvoice(PurchaseInvoicesRequest $request)
    {
       
        //store to invoice
        $invoice = new Invoice([
            'code' => $request->code,
            'total' => $request->total,
            'paid'=>$request->paid,
            'type' => "purchases"
        ]);
        $invoice->save();
        $invoice_id=$invoice->id;
        if ($request->paid==$request->total) {
            DB::update('update invoices set status= ? where id = ?',['paid',$invoice_id]);
        }

        //store to invoice_purchase
        $countproduct = count($request->product);
        for ($i = 0; $i < $countproduct; $i++) { 
            $product_id=$request->product[$i]['product_id'];
            $amounInProducts=Product::findOrFail($product_id)->amount;
            $price=$request->product[$i]['purchase_price'];
            $amount=$request->product[$i]['amount'];
        
        $supplier_id=$request->supplier_id;
        $supplier= Supplier::findOrFail($supplier_id);
        $supplier ->Products()
        ->attach($request->supplier_id,['purchase_price' =>$price,'amount' =>$amount,'supplier_id'=>$supplier_id,'product_id'=>$product_id,'invoice_id'=>$invoice_id]);
        $supplier->save(); 
        //store to selected inventory
        $product = Product::findOrFail($product_id);
        $productsinthisinventory = $product->inventories()->where('inventory_id',$request->inventory_id)->exists();

        if ($productsinthisinventory){
         $oldamount = $product->inventories()->findOrFail($request->inventory_id, ['inventory_id'])->pivot->amount;

         $newamount = $oldamount+$amount;

         $product->inventories()->updateExistingPivot($request->inventory_id,['amount'=> $newamount]);

        }else{
          $product -> inventories()
         ->attach($request->inventory_id,['amount' => $amount]);
        }

         $product->amount += $amount;
         $product->save();
        //update product amount in products
        $updateAmountInProducts =$amounInProducts + $request->product[$i]['amount'];
        DB::update('update products set amount= ? where id = ?',[$updateAmountInProducts,$product_id]);
        return response()->json(['status' => true, 'msg' => 'your purchases invoice saved']);

        }
    }
}
