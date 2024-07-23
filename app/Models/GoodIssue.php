<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodIssue extends Model
{
    use HasFactory;
    protected $fillable = [
        'issuer_id',
        'product_id',
        'quantity',
    ];

    public function issuer()
    {
        return $this->belongsTo(User::class, 'issuer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
