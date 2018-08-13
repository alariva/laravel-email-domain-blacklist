<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Email Domain Blackist Validation
    |--------------------------------------------------------------------------
    |
    | The email domain blacklist validation rule uses a remote or local source
    | to get updated and also allows to specify a custom append list.
    |
    | source: string|null
    |         You may specify the preferred URL or file path to update the
    |         blacklist.
    |         Keep null if you don't want to use a remote source.
    |         Default: "https://raw.githubusercontent.com/ivolo/disposable-email-domains/master/index.json"
    |
    | cache-key: string|null
    |         You may change the cache key for the sourced blacklist.
    |         Keep null if you want to use the default value.
    |
    | auto-update: true|false
    |         Specify if should automatically get source when cache is empty.
    |         ADVICE: This may slow down the first request upon validation.
    |         Default: false
    |
    | append: string|null
    |         You may a string of pipe | separated domains list.
    |         Keep null if you don't want to append custom domains.
    |         Example: "example.com|example.net|foobar.com".
    |
    | custom_message: string|null
    |         You may override the default custom message translation key.
    |         Example: "domain not allowed".
    |         Example: "validation.key".
    |         Default: null
    |
    */

    'email' => [

        'blacklist' => [

            'source' => 'https://raw.githubusercontent.com/ivolo/disposable-email-domains/master/index.json',

            'cache-key' => 'email.domains.blacklist',

            'auto-update' => false,

            'append' => null,

            'custom_message' => null,

        ],

    ],

];
