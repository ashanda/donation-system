<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'description', 'price'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->product_code = self::generateProductCode();
        });
    }

    private static function generateProductCode()
    {
        return 'PROD-' . strtoupper(uniqid());
    }
}
