<?php

namespace Database\Factories\Dealskoo\Trial\Models;

use Dealskoo\Product\Models\Product;
use Dealskoo\Trial\Models\Trial;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Trial::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'slug' => $this->faker->slug,
            'quantity' => $this->faker->numberBetween(0, 100),
            'ship_fee' => $this->faker->numberBetween(0, 100),
            'product_id' => Product::factory(),
            'refund' => function ($trial) {
                return $this->faker->numberBetween(0, Product::find($trial['product_id'])->price);
            },
            'seller_id' => function ($trial) {
                return Product::find($trial['product_id'])->seller_id;
            },
            'category_id' => function ($trial) {
                return Product::find($trial['product_id'])->category_id;
            },
            'country_id' => function ($trial) {
                return Product::find($trial['product_id'])->country_id;
            },
            'brand_id' => function ($trial) {
                return Product::find($trial['product_id'])->brand_id;
            },
            'platform_id' => function ($trial) {
                return Product::find($trial['product_id'])->platform_id;
            },
            'start_at' => $this->faker->dateTime,
            'end_at' => $this->faker->dateTime
        ];
    }

    public function approved()
    {
        return $this->state(function (array $attributes) {
            return [
                'approved_at' => $this->faker->dateTime,
            ];
        });
    }

    public function avaiabled()
    {
        return $this->state(function (array $attributes) {
            return [
                'start_at' => $this->faker->dateTimeBetween('-1 days'),
                'end_at' => $this->faker->dateTimeBetween('now', '+7 days'),
                'approved_at' => $this->faker->dateTime,
            ];
        });
    }
}
