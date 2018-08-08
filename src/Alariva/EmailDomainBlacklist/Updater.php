<?php

namespace Alariva\EmailDomainBlacklist;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * 
 */
class Updater
{
    public static function update()
    {
        $url = config('validation.email.blacklist.source');

        if (is_null($url)) {
            return false;
        }

        // Define parameters for the cache
        $key = config('validation.email.blacklist.cache-key', 'email.domains.blacklist');
        $duration = Carbon::now()->addMonth();

        $domains = json_decode(file_get_contents($url), true);

        $count = count($domains);

        // Retrieve blacklisted domains
        Cache::put($key, $domains, $duration);

        return $count;
    }
}
