<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Product extends Model
{
    use HasApiTokens, HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'category_id',
    ];

    public function category()
    {
        return $this->HasMany(Category::class);
    }
}
