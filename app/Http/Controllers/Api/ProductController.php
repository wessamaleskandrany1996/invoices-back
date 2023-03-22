<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResourse;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index (){
        $products = Product::paginate(15);
        return ProductResourse::collection($products);
    }
    public function show($id){
         $product = Product::findOrFail($id);
         return new ProductResourse($product);
    }
    public function store(ProductRequest $request){
        $product = Product::create([
            'name'=> $request-> name,
            'purchase_price'=> $request->purchase_price,
            'sell_price'=> $request->sell_price,
            'amount'=> $request->amount,
            'category_id'=>$request->category_id
        ]);
        return new ProductResourse($product);
    }
    public function update(ProductRequest $request,$id){
        $product = Product::findOrFail($id);
        $product -> update([
            'name'=> $request-> name,
            'purchase_price'=> $request->purchase_price,
            'sell_price'=> $request->sell_price,
            'amount'=> $request->amount,
            'category_id'=>$request->category_id
        ]);
        return new ProductResourse($product);
    }
    public function destroy($id){
        $product = Product::findOrFail($id);
        $product->delete();
        return "product has been deleted";
    }

}
