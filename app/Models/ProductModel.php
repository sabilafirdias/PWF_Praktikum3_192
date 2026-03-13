<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'qty',
        'price',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kategoris(): HasMany
    {
        return $this->hasMany(KategoriModel::class, 'product_id');
    }
}
