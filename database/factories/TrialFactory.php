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
        $product = Product::factory()->approved()->create();
        return [
            'title' => $this->faker->title,
            'slug' => $this->faker->slug,
            'refund' => $this->faker->numberBetween(0, 100),
            'quantity' => $this->faker->numberBetween(0, 100),
            'ship_fee' => $this->faker->numberBetween(0, 100),
            'seller_id' => $product->seller_id,
            'product_id' => $product->id,
            'category_id' => $product->category_id,
            'country_id' => $product->country_id,
            'brand_id' => $product->brand_id,
            'platform_id' => $product->platform_id,
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
