<?php

namespace Database\Seeders;

use App\Domains\Coupon\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coupon = new Coupon;
        $coupon->name = 'ABC1234';
        $coupon->amount = 5;

        $coupon->save();
    }
}
