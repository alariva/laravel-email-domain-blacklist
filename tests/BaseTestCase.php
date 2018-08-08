<?php

namespace Tests;

use Alariva\EmailDomainBlacklist\EmailDomainBlacklistServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class BaseTestCase extends OrchestraTestCase
{
    /**
     * Load package service provider
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return Alariva\EmailDomainBlacklist\EmailDomainBlacklistServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [EmailDomainBlacklistServiceProvider::class];
    }
}
