<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = ['name','location','type'];

    public function products()
    {
        return $this->belongsToMany(Product::class,'store_product_inventory','inventory_id','product_id')->withPivot('amount')->withTimestamps();
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class);
    }
    public function customers()
    {
        return $this->belongsToMany(Customer::class);
    }
    public function invoices()
    {
        return $this->belongsToMany(Invoice::class);
    }
    public function transactionProducts()
    {
        return $this->belongsToMany(Product::class,'provide','inventory_id','shop_id','product_id')->withPivot('amount')->withTimestamps();
    }
    public function inventories()
    {
        return $this->belongsToMany(inventory::class,'provide','inventory_id','shop_id','product_id')->withPivot('amount')->withTimestamps();
    }
    public function transaction()
    {
        return $this->belongsToMany(Product::class,'provide','inventory_id','product_id')->withPivot('amount')->withTimestamps();
    }
}
