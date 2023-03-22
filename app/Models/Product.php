<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','sell_price','amount','category_id'];

    public function inventories()
    {
        return $this->belongsToMany(Inventory::class,'store_product_inventory','product_id','inventory_id')->withPivot('amount')->withTimestamps();
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'make_invoices_purchases','supplier_id', 'product_id','invoice_id')->withPivot('amount', 'purchase_price')->withTimestamps();
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'make_invoices_purchases','supplier_id', 'product_id','invoice_id')->withPivot('amount', 'purchase_price')->withTimestamps();
    }
    public function transactionInventories()
    {
        return $this->belongsToMany(Inventory::class,'store_product_inventory','product_id','inventory_id')->withPivot('amount')->withTimestamps();
    }
    public function sellInvoices()
    {
        return $this->belongsToMany(Invoice::class, 'make_invoices_sales','customer_id', 'product_id','invoice_id')->withPivot('amount', 'sell_price')->withTimestamps();
    }
    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'make_invoices_sales','customer_id', 'product_id','invoice_id')->withPivot('amount', 'sell_price')->withTimestamps();

    }
    public function purchasesInvoices()
    {
        return $this->belongsToMany(Invoice::class, 'make_invoices_purchases','product_id','invoice_id')->withPivot('amount', 'purchase_price')->withTimestamps();
    }
    public function salesInvoices()
    {
        return $this->belongsToMany(Invoice::class, 'make_invoices_sales','product_id','invoice_id')->withPivot('amount', 'sell_price')->withTimestamps();
    }

}

