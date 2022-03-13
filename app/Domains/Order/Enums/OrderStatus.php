<?php

namespace App\Domains\Order\Enums;

/**
 * Class OrderStatus
 * @package App\Domains\Order\Enums
 */
class OrderStatus
{
    const STATUS_PENDING = 'pending';

    const STATUS_COMPLETED = 'completed';

    const STATUS_CANCELLED = 'cancelled';
}
