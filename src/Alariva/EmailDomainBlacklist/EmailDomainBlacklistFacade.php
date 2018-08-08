<?php

namespace Alariva\EmailDomainBlacklist;

use Illuminate\Support\Facades\Facade;

class EmailDomainBlacklistFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'email-domain-blacklist';
    }
}