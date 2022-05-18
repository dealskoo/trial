<?php

namespace Dealskoo\Trial\Tests\Unit;

use Dealskoo\Image\Models\Image;
use Dealskoo\Trial\Models\Trial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Trial\Tests\TestCase;
use Illuminate\Support\Str;

class TrialTest extends TestCase
{
    use RefreshDatabase;

    public function test_cover()
    {
        $image = Image::factory()->make();
        $trial = Trial::factory()->create();
        $trial->product->images()->save($image);
        $this->assertNotNull($trial->cover);
    }

    public function test_slug()
    {
        $slug = 'Trial';
        $trial = Trial::factory()->create();
        $trial->slug = $slug;
        $trial->save();
        $trial->refresh();
        $this->assertEquals($trial->slug, Str::lower($slug));
    }

    public function test_approved()
    {
        $trial = Trial::factory()->approved()->create();
        $this->assertCount(Trial::approved()->count(), Trial::all());
    }

    public function test_avaiabled()
    {
        $trial = Trial::factory()->avaiabled()->create();
        $this->assertCount(Trial::avaiabled()->count(), Trial::all());
    }
}
