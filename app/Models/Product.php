<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = ['sku', 'name'];

    public function batches()
    {
        return $this->hasOne(Batch::class);
    }
    public function transactions()
    {
        return $this->hasOne(Transaction::class);
    }
}
