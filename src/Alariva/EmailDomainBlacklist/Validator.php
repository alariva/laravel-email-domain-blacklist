<?php

namespace Alariva\EmailDomainBlacklist;

use Carbon\Carbon;
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
        $this->domains = Cache::get('domains.blacklisted', []);

        $this->append();
    }

    protected function append()
    {
        $appendList = config('root.validation.email.blacklist.append');

        if ($appendList === null) {
            return;
        }

        $appendDomains = explode('|', $appendList);

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
        return "The domain for $attribute is not allowed. Please use another email address.";
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
