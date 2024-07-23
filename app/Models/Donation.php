<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'donator_id',
        'product_id',
        'quantity',
    ];

    public function donator()
    {
        return $this->belongsTo(User::class, 'donator_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
