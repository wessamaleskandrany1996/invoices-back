<?php

namespace App\Http\Controllers\api;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SellInvoicesRequest;

class SalesInvoiceController extends Controller
{
    public function sellInvoice(SellInvoicesRequest $request)
    {
        $inventory_id=$request->inventory_id;
        $code= Str::random(12);

        //if it postpond you must enter client
        if (!(($request->customer_id)||($request->customerName))&&($request->paid!=$request->total)) {
            return response()->json(['status' => true, 'msg' => 'you must choose client']);
        }
        // store to invoice
        $invoice = new Invoice([
            'code' => $code,
            'total' => $request->total,
            'paid'=>$request->paid,
            'type' => "sales"
        ]);
        $invoice->save();
        if ($request->customerName) {
           if ($request->customerPhone) {
            # code...
            $customer = new Customer([
                'name' => $request->customerName,
                'phone' => $request->customerPhone,
            ]);
            $customer->save();
        }else {
            return response()->json(['status' => true, 'msg' => 'you must enter the customer phone']);

        }
            $customer_id=$customer->id;
        }

        $invoice_id=$invoice->id;
        if ($request->paid==$request->total) {
            DB::update('update invoices set status= ? where id = ?',['paid',$invoice_id]);
        }

        //store to invoice_sales
        $countproduct = count($request->product);
        for ($i = 0; $i < $countproduct; $i++) {
            $amount=$request->product[$i]['amount'];
            $product_id=$request->product[$i]['product_id'];
            $product = Product::findOrFail($product_id);
            $productsInInventory=$product->inventories()->where('inventory_id',$request->inventory_id)->exists();
            $price=$request->product[$i]['sell_price'];
            $invoicesales= Invoice::findOrFail($invoice_id);

            $amounInProducts=Product::findOrFail($product_id)->amount;
            if ($request->customer_id) {
                $customer_id=$request->customer_id;
            }
            try {
                $invoicesales ->sellProducts()
                ->attach($invoice_id,['sell_price' =>$price,'amount' =>$amount,'customer_id'=>$customer_id,'product_id'=>$product_id,'invoice_id'=>$invoice_id]);
                $invoicesales->save();
                //update product amount in products
                $updateAmountInProducts =$amounInProducts - $amount;
                DB::update('update products set amount= ? where id = ?',[$updateAmountInProducts,$product_id]);
                //update product amount in inventory
                if ($productsInInventory) {
                    $amountOfProductInTheInventory=$product->inventories()->findOrFail($request->inventory_id, ['inventory_id'])->pivot->amount;
                    if ( $amountOfProductInTheInventory>=$amount){
                    $updateAmountInInventory=$amountOfProductInTheInventory- $amount;
                    DB::update('update store_product_inventory set amount= ? where inventory_id = ? && product_id= ?',[$updateAmountInInventory,$inventory_id,$product_id]);
                    if ($updateAmountInInventory==0) {
                        DB::table('store_product_inventory')->where('inventory_id', $inventory_id)->delete();
                    }}else {
                        return response()->json(['status' => true, 'msg' => 'No enough products in this inventory']);
                    }
                }else {
                    return response()->json(['status' => true, 'msg' => 'No products in this inventory']);

                }

                return response()->json(['status' => true, 'msg' => 'your sales invoice saved']);

        } catch (\Throwable $th) {
            $invoicesales ->sellProducts()
            ->attach($request->invoice_id,['sell_price' =>$price,'amount' =>$amount,'product_id'=>$product_id,'invoice_id'=>$invoice_id]);
            $invoicesales->save();
        return response()->json(['status' => true, 'msg' => 'your sales invoice saved']);

        }

        // return response()->json(['status' => true, 'msg' => 'your sales invoice saved']);

        }
    }
    public function getSalesInvoice()
    {
        // $SalesInvoice = DB::table('make_invoices_sales')->distinct()->paginate(15);

        $SalesInvoice= DB::table('make_invoices_sales')
        ->join('products', function ($join) {
        $join->on('products.id', '=', 'make_invoices_sales.product_id');
        })
        ->paginate(15);

        return $SalesInvoice;
    }

}

