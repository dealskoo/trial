<?php

namespace Dealskoo\Trial\Tests\Feature;

use Dealskoo\Admin\Facades\AdminMenu;
use Dealskoo\Seller\Facades\SellerMenu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Dealskoo\Trial\Tests\Testcase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu()
    {
        $this->assertNotNull(AdminMenu::findBy('title', 'trial::trial.trials'));
        $childs = AdminMenu::findBy('title', 'trial::trial.trials')->getChilds();
        $menu = collect($childs)->where('title', 'trial::trial.trials');
        $this->assertNotEmpty($menu);

        $this->assertNotNull(SellerMenu::findBy('title', 'trial::trial.trials'));
        $childs = SellerMenu::findBy('title', 'trial::trial.trials')->getChilds();
        $menu = collect($childs)->where('title', 'trial::trial.trials');
        $this->assertNotEmpty($menu);
    }
}
