<?php

namespace App\Domains\Order\Models;

use App\Domains\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Order
 * @package App\Domains\Order\Models
 */
class Order extends Model
{
    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
