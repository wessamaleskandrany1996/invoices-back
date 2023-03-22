<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Inventory;
// use Illuminate\Http\Client\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;



class TransactionController extends Controller
{
    public function transaction(TransactionRequest $request){
    // return $request;
        $countproduct = count($request->product);
        
        
        
        for ($i = 0; $i < $countproduct; $i++) { 
            $product = Product::findOrFail($request->product[$i]['product_id']);
            $productsInInventory=$product->inventories()->where('inventory_id',$request->inventory_id)->exists();
            $productsInShop=$product->inventories()->where('inventory_id',$request->shop_id)->exists();
    
            //if product in inventory
            if ($productsInInventory) {
                $requestedAmount= $request->product[$i]['amount'];
                $amountOfProductInTheInventory=$product->inventories()->findOrFail($request->inventory_id, ['inventory_id'])->pivot->amount;          
                if ($amountOfProductInTheInventory>=$requestedAmount) {
                    if ($productsInShop) {
                        $amountOfProductInShop=$product->inventories()->findOrFail($request->shop_id, ['inventory_id'])->pivot->amount;          
                        //make direct transaction
                        $amount = $request->product[$i]['amount'];
                        $product_id=$request->product[$i]['product_id'];
                        $inventory_id=$request->inventory_id;
                        $shop_id=$request->shop_id;
                        $shop = Inventory::findOrFail($request->shop_id);
                        $inventory= Inventory::findOrFail($request->inventory_id);
                        $shop -> transactionProducts()
                        ->attach($request->shop_id,['amount' =>$amount,'product_id'=>$product_id,'inventory_id'=>$inventory_id]);
                       
                        //increase product amount in shop
                        //decrease product amount in inventory 
                        $updateAmountIninventory =$amountOfProductInTheInventory- $request->product[$i]['amount'];
                        $updateAmountInShop = $amountOfProductInShop+ $request->product[$i]['amount'];
                        $shop->save();  
                        DB::update('update store_product_inventory set amount= ? where inventory_id = ? && product_id= ?',[$updateAmountIninventory,$inventory_id,$product_id]);
                        DB::update('update store_product_inventory set amount= ? where inventory_id = ? && product_id= ?',[$updateAmountInShop,$shop_id,$product_id]);
                        if ($updateAmountIninventory==0) {
                            DB::table('store_product_inventory')->where('inventory_id', $inventory_id)->delete();
                        }
                        
                        return response()->json(['status' => true, 'msg' => 'Your transaction done']);
                        
                    }else {
                        $product_id=$request->product[$i]['product_id'];
                            $inventory_id=$request->inventory_id;
                            $shop_id=$request->shop_id;
                    
                    //store product in this shop
                    $product = Product::findOrFail($request->product[$i]['product_id']);
                    $product -> inventories()
                    ->attach($request->shop_id,['amount' => $requestedAmount]);
                    $product->save();
                    //decrease product amount in inventory 
                    $updateAmountIninventory =$amountOfProductInTheInventory- $request->product[$i]['amount'];
                    DB::update('update store_product_inventory set amount= ? where inventory_id = ? && product_id= ?',[$updateAmountIninventory,$inventory_id,$product_id]);

                    //make transaction
                    $amount = $request->product[$i]['amount'];
                        $product_id=$request->product[$i]['product_id'];
                        $inventory_id=$request->inventory_id;
                        $shop_id=$request->shop_id;
                        $shop = Inventory::findOrFail($request->shop_id);
                        $inventory= Inventory::findOrFail($request->inventory_id);
                        $shop -> transactionProducts()
                        ->attach($request->shop_id,['amount' =>$amount,'product_id'=>$product_id,'inventory_id'=>$inventory_id]);
                        $shop->save();
                        return response()->json(['status' => true, 'msg' => 'Your transaction done']);


                  }
                
            }
            else {
                return response()->json(['status' => true, 'msg' => 'No enough products in this inventory']);

              }
            }else {
                return response()->json(['status' => true, 'msg' => 'No products in this inventory']);
            }
            }//end for
          
    }
    //get transactions
    public function getTransaction()
    {
        
        $transaction = DB::table('provide')->distinct()->paginate(15);
        // return TransactionResource::collection($transaction) ;
        
        return $transaction;

    }
    public function getTransactionByDate(Request $request)
    {
        $from=$request->input('from');
        $to=$request->input('to');
        $transaction = DB::table('provide')
           ->whereBetween('created_at', [$from, $to])
           ->get();
        return $transaction;

    }
}
