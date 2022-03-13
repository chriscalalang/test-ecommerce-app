<?php

namespace Database\Factories\Domains\Product\Models;

use App\Domains\Product\Enums\ProductStatus;
use App\Infrastractures\ValueObjects\Finance\Currency\USD\USD;
use App\Infrastractures\ValueObjects\Finance\FinancialQuantity\Dollars\Dollars;
use App\Infrastractures\ValueObjects\Finance\Money\Money\Money;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Domains\Product\Models\Product::class;

    /**
     * Define the model's default state.
     *
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'price' => $this->faker->numberBetween(1, 10)
        ];
    }
}
