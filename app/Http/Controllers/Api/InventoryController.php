<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryRequest;
use App\Http\Resources\InventoryResourse;
use App\Models\Inventory;


class InventoryController extends Controller
{
    public function index (){
        $inventories = Inventory::paginate(15);
        return InventoryResourse::collection($inventories);
    }

    public function show ($id){

        $inventory = Inventory::findOrFail($id);
        return new InventoryResourse($inventory);
    }

    public function store (InventoryRequest $request){
        $inventory = Inventory::create([
           'name' => $request->name,
          'location' => $request->location,
          'type'=>$request->type
        ]);
        return new InventoryResourse($inventory);

    }

    public function update (InventoryRequest $request,$id){

      $inventory = Inventory::find($id);
      $inventory -> update([
         'name' => $request->name,
         'location' => $request->location,
         'type'=>$request->type
      ]);
       return new InventoryResourse($inventory);
    }

    public function destroy($id){
        $inventory = Inventory::findOrFail($id);
        $inventory ->delete();
        return "inventory has been deleted";
    }
}
