<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'code', 'price', 'quantity', 'performed_at'];

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class)->withPivot('price', 'quantity');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
