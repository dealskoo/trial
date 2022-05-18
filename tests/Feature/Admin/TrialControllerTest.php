<?php

namespace Dealskoo\Trial\Tests\Feature\Admin;

use Dealskoo\Admin\Models\Admin;
use Dealskoo\Country\Models\Country;
use Dealskoo\Trial\Models\Trial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Trial\Tests\TestCase;

class TrialControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.trials.index'));
        $response->assertStatus(200);
    }

    public function test_table()
    {
        $admin = Admin::factory()->isOwner()->create();
        $response = $this->actingAs($admin, 'admin')->get(route('admin.trials.index'), ['HTTP_X-Requested-With' => 'XMLHttpRequest']);
        $response->assertJsonPath('recordsTotal', 0);
        $response->assertStatus(200);
    }

    public function test_show()
    {
        $country = Country::factory()->create(['alpha2' => 'US']);
        $admin = Admin::factory()->isOwner()->create();
        $trial = Trial::factory()->create(['country_id' => $country]);
        $response = $this->actingAs($admin, 'admin')->get(route('admin.trials.show', $trial));
        $response->assertStatus(200);
    }

    public function test_edit()
    {
        $country = Country::factory()->create(['alpha2' => 'US']);
        $admin = Admin::factory()->isOwner()->create();
        $trial = Trial::factory()->create(['country_id' => $country]);
        $response = $this->actingAs($admin, 'admin')->get(route('admin.trials.edit', $trial));
        $response->assertStatus(200);
    }

    public function test_update()
    {
        $admin = Admin::factory()->isOwner()->create();
        $trial = Trial::factory()->create();
        $response = $this->actingAs($admin, 'admin')->put(route('admin.trials.update', $trial), [
            'slug' => 'deals',
            'approved' => true
        ]);
        $response->assertStatus(302);
    }
}
