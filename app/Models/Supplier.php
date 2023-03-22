<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'make_invoices_purchases','supplier_id', 'product_id','invoice_id')->withPivot('amount', 'purchase_price')->withTimestamps();
    }
    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'make_invoices_purchases','supplier_id', 'product_id','invoice_id')->withPivot('amount', 'purchase_price')->withTimestamps();
        
    }
}
