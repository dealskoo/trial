<?php

namespace Dealskoo\Trial\Providers;

use Dealskoo\Admin\Facades\AdminMenu;
use Dealskoo\Admin\Facades\PermissionManager;
use Dealskoo\Admin\Permission;
use Dealskoo\Seller\Facades\SellerMenu;
use Illuminate\Support\ServiceProvider;

class TrialServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

            $this->publishes([
                __DIR__ . '/../../resources/lang' => resource_path('lang/vendor/trial')
            ], 'lang');
        }

        $this->loadRoutesFrom(__DIR__ . '/../../routes/admin.php');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/seller.php');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'trial');

        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'trial');

        AdminMenu::dropdown('trial::trial.trials', function ($menu) {
            $menu->route('admin.trials.index', 'trial::trial.trials', [], ['permission' => 'trials.index']);

        }, ['icon' => 'uil-moneybag', 'permission' => 'trial.trial'])->order(2);

        PermissionManager::add(new Permission('trial.trial', 'Trial'));
        PermissionManager::add(new Permission('trials.index', 'Trial List'), 'trial.trial');
        PermissionManager::add(new Permission('trials.show', 'View Trial'), 'trials.index');
        PermissionManager::add(new Permission('trials.edit', 'Edit Trial'), 'trials.index');

        SellerMenu::dropdown('trial::trial.trials', function ($menu) {
            $menu->route('seller.trials.index', 'trial::trial.trials');

        }, ['icon' => 'uil-moneybag me-1'])->order(3);
    }
}
