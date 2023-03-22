<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Client\Request;

class StoreProductController extends Controller
{
    public function StoreProduct(StoreProductRequest $request){
         $product = Product::findOrFail($request->product_id);
        $amount = $request->amount;

        $exists_inventory = $product->inventories()->where('inventory_id',$request->inventory_id)->exists();

        if ($exists_inventory){
         $old_amount = $product->inventories()->findOrFail($request->inventory_id, ['inventory_id'])->pivot->amount;

         $new_amount = $old_amount+$amount;

         $product->inventories()->updateExistingPivot($request->inventory_id,['amount'=> $new_amount]);

        }else{
          $product -> inventories()
         ->attach($request->inventory_id,['amount' => $amount]);
        }

         $product->amount += $amount;
         $product->save();
        return "product has been added to the selected inventory";
    }
}
