<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'performed_at'];
    
    const TYPE_INCOME = 'income';
    const TYPE_OUTCOME = 'outcome';
    const TYPES = [self::TYPE_INCOME, self::TYPE_OUTCOME];
    
    public function batches()
    {
        return $this->belongsToMany(Batch::class)->withPivot('price', 'quantity');
    }
}
