<?php

namespace Dealskoo\Trial\Tests\Feature;

use Dealskoo\Admin\Facades\PermissionManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Trial\Tests\TestCase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_permissions()
    {
        $this->assertNotNull(PermissionManager::getPermission('trial.trial'));
        $this->assertNotNull(PermissionManager::getPermission('trials.index'));
    }
}
