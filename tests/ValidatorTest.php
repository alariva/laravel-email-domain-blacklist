<?php

namespace Tests;

use Config;
use Validator;
use Tests\BaseTestCase;

class ValidatorTest extends BaseTestCase
{
    /**
     * Test it rejects emails with domains that ARE blacklisted by append
     * @return void
     */
    public function test_rejects_blacklisted_by_append()
    {
    	Config::set('validation.email.blacklist.source', null);
    	Config::set('validation.email.blacklist.append', "reject.me");

		$rules = ['email' => 'email|blacklist'];

		$input = ['email' => 'rejectme@reject.me'];

		$passes = Validator::make($input, $rules)->passes();

		$this->assertFalse($passes);
    }

    /**
     * Test it rejects emails with domains that ARE blacklisted by append of multi items
     * @return void
     */
    public function test_rejects_blacklisted_by_append_multi()
    {
    	Config::set('validation.email.blacklist.source', null);
    	Config::set('validation.email.blacklist.append', "reject.me|rejecthisother.com");

		$rules = ['email' => 'email|blacklist'];

		$input = ['email' => 'rejectme@rejecthisother.com'];

		$passes = Validator::make($input, $rules)->passes();

		$this->assertFalse($passes);
    }

    /**
     * Test it rejects emails with domains that ARE blacklisted AnY CaSe TyPeD
     * @return void
     */
    public function test_rejects_blacklisted_by_append_lowercase()
    {
    	Config::set('validation.email.blacklist.source', null);
    	Config::set('validation.email.blacklist.append', "rejectthisother.com");

		$rules = ['email' => 'email|blacklist'];

		$input = ['email' => 'rejectme@REJECTthisOTHER.CoM'];

		$passes = Validator::make($input, $rules)->passes();

		$this->assertFalse($passes);
    }

    /**
     * Test it allows emails with domains that are NOT blacklisted by append
     * @return void
     */
    public function test_rejects_allows_not_blacklisted_by_append()
    {
    	Config::set('validation.email.blacklist.source', null);
    	Config::set('validation.email.blacklist.append', "notinsource.com|otherappend.com");

		$rules = ['email' => 'email|blacklist'];

		$input = ['email' => 'rejectme@letmein.com'];

		$passes = Validator::make($input, $rules)->passes();

		$this->assertTrue($passes);
    }

    /**
     * Test it allows emails with domains that are NOT blacklisted
     * @return void
     */
    public function test_rejects_allows_not_blacklisted_by_source()
    {
    	Config::set('validation.email.blacklist.auto-update', true);
    	Config::set('validation.email.blacklist.source', __DIR__.'/stubs/source.json');

		$rules = ['email' => 'email|blacklist'];

		$input = ['email' => 'rejectme@example.com'];

		$passes = Validator::make($input, $rules)->passes();

		$this->assertFalse($passes);
    }
}