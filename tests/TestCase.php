<?php

namespace Dealskoo\Trial\Tests;

use Dealskoo\Trial\Providers\TrialServiceProvider;

abstract class TestCase extends \Dealskoo\Billing\Tests\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            TrialServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [];
    }

    protected function setUp(): void
    {
        parent::setUp();
    }
}
