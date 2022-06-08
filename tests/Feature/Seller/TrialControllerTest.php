<?php

namespace Dealskoo\Trial\Tests\Feature\Seller;

use Dealskoo\Country\Models\Country;
use Dealskoo\Product\Models\Product;
use Dealskoo\Seller\Models\Seller;
use Dealskoo\Trial\Models\Trial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Trial\Tests\TestCase;
use Illuminate\Support\Arr;

class TrialControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $seller = Seller::factory()->create();
        $response = $this->actingAs($seller, 'seller')->get(route('seller.trials.index'));
        $response->assertStatus(200);
    }

    public function test_table()
    {
        $seller = Seller::factory()->create();
        $response = $this->actingAs($seller, 'seller')->get(route('seller.trials.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $response->assertJsonPath('recordsTotal', 0);
        $response->assertStatus(200);
    }

    public function test_create()
    {
        $country = Country::factory()->create(['alpha2' => 'US']);
        $seller = Seller::factory()->create();
        $response = $this->actingAs($seller, 'seller')->get(route('seller.trials.create'));
        $response->assertStatus(200);
    }

    public function test_store()
    {
        $seller = Seller::factory()->create();
        $product = Product::factory()->approved()->create(['seller_id' => $seller->id]);
        $trial = Trial::factory()->make(['seller_id' => $seller->id, 'product_id' => $product->id]);
        $response = $this->actingAs($seller, 'seller')->post(route('seller.trials.store'), Arr::collapse([$trial->only([
            'title',
            'refund',
            'quantity',
            'product_id',
            'ship_fee'
        ]), ['activity_date' => $trial->start_at->format('m/d/Y') . ' - ' . $trial->end_at->format('m/d/Y')]]));
        $response->assertStatus(302);
    }

    public function test_edit()
    {
        $country = Country::factory()->create(['alpha2' => 'US']);
        $seller = Seller::factory()->create();
        $trial = Trial::factory()->create(['seller_id' => $seller->id, 'country_id' => $country->id]);
        $response = $this->actingAs($seller, 'seller')->get(route('seller.trials.edit', $trial));
        $response->assertStatus(200);
    }

    public function test_update()
    {
        $seller = Seller::factory()->create();
        $trial = Trial::factory()->create(['seller_id' => $seller->id]);
        $trial1 = Trial::factory()->make();
        $response = $this->actingAs($seller, 'seller')->put(route('seller.trials.update', $trial), $trial1->only([
            'title',
            'refund',
            'quantity',
            'product_id',
            'ship_fee'
        ]));
        $response->assertStatus(302);
    }

    public function test_destroy()
    {
        $seller = Seller::factory()->create();
        $trial = Trial::factory()->create(['seller_id' => $seller->id]);
        $response = $this->actingAs($seller, 'seller')->delete(route('seller.trials.destroy', $trial));
        $response->assertStatus(200);
    }
}
