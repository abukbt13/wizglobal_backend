<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockPrice extends Model
{
    protected $fillable = ['stock', 'price', 'date'];

    protected $casts = [
        'price' => 'decimal:2',
        'date'  => 'date',
    ];
}
