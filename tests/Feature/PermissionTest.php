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
        $this->assertNotNull(PermissionManager::getPermission('deals.index'));
        $this->assertNotNull(PermissionManager::getPermission('deals.show'));
        $this->assertNotNull(PermissionManager::getPermission('deals.edit'));
    }
}
