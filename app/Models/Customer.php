<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'make_invoices_sales','customer_id', 'product_id','invoice_id')->withPivot('amount', 'sell_price')->withTimestamps();
    }
    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'make_invoices_sales','invoice_id','customer_id')->withPivot('amount', 'sell_price')->withTimestamps();

    }
}
