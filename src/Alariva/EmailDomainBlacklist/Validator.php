<?php

namespace Alariva\EmailDomainBlacklist;

use Alariva\EmailDomainBlacklist\Updater;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class Validator
{
    /**
     * Array of blacklisted domains.
     **/
    private $domains = [];

    /**
     * Retrieve latest selection of blacklisted domains and cache them.
     *
     * @param none.
     *
     * @return void.
     **/
    public function refresh()
    {
        // Retrieve blacklisted domains from the cache
        $this->domains = Cache::get(config('validation.email.blacklist.cache-key', 'email.domains.blacklist'), []);

        $this->shouldUpdate();

        $this->appendCustomDomains();
    }

    protected function shouldUpdate()
    {
        $autoupdate = config('validation.email.blacklist.auto-update');

        if ($autoupdate && !Cache::has(config('validation.email.blacklist.cache-key', 'email.domains.blacklist'))) {
            Updater::update();
        }
    }

    protected function appendCustomDomains()
    {
        $appendList = config('validation.email.blacklist.append');

        if ($appendList === null) {
            return;
        }

        $appendDomains = explode('|', strtolower($appendList));

        $this->domains = array_merge($this->domains, $appendDomains);
    }

    /**
     * Generate the error message on validation failure.
     *
     * @param string $message.
     * @param string $attribute.
     * @param string $rule.
     * @param array $parameters.
     *
     * @return string.
     **/
    public function message($message, $attribute, $rule, $parameters)
    {
        // Provide custom error message
        return __('The domain for :attribute is not allowed. Please use another email address.', ['attribute' => $attribute]);
    }

    /**
     * Execute the validation routine.
     *
     * @param string $attribute.
     * @param string $value.
     * @param array $parameters.
     *
     * @return bool.
     **/
    public function validate($attribute, $value, $parameters)
    {
        $this->refresh();

        $domain = str_after(strtolower($value), '@');

        return !in_array($domain, $this->domains);
    }
}
