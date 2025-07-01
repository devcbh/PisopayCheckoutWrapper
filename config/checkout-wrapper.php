<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Endpoint
    |--------------------------------------------------------------------------
    |
    | The base URL for the API.
    |
    */
    'api_endpoint' => env('CHECKOUT_API_ENDPOINT', ''),

    /*
    |--------------------------------------------------------------------------
    | API Version
    |--------------------------------------------------------------------------
    |
    | The version of the API to use.
    |
    */
    'api_version' => env('CHECKOUT_API_VERSION', ''),

    /*
    |--------------------------------------------------------------------------
    | API Credentials
    |--------------------------------------------------------------------------
    |
    | The username and password for API authentication.
    |
    */
    'api_username' => env('CHECKOUT_API_USERNAME', ''),
    'api_password' => env('CHECKOUT_API_PASSWORD', ''),
];