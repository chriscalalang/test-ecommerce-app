<?php

namespace App\Domains\Product\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Product
 * @package App\Domains\Product\Models
 */
class Product extends Model
{
    use HasFactory;

    /**
     * @return HasMany
     */
    public function inventories(): HasMany
    {
        return $this->hasMany(ProductInventory::class);
    }
}
