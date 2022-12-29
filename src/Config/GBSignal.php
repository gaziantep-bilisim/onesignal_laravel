<?php
return [

    /*
    |-------------------------------------------------------------------------------------------
    | URL - One Signal have different endpoint.
    |-------------------------------------------------------------------------------------------
    |
    */
    'url' => env('ONESIGNAL_URL', 'https://onesignal.com/api/v1/'),

    /*
    |-------------------------------------------------------------------------------------------
    | App Id - One Signal have different app id for every app.
    |
    | Based on App you are using, you can change the App Id here and specify here
    |-------------------------------------------------------------------------------------------
    |
    */
    'app_id' => env('ONESIGNAL_APP_ID'),

    /*
    |-------------------------------------------------------------------------------------------
    | Authorize - One Signal have different Authorize for every app.
    |
    | Based on App you are using, you can change the Authorize here and specify here
    |-------------------------------------------------------------------------------------------
    |
    */

    'authorize' => env('ONESIGNAL_AUTHORIZE'),

    /*
    |-------------------------------------------------------------------------------------------
    | Auth Key - One Signal have Auth key of account.
    |
    | You can manage apps
    |-------------------------------------------------------------------------------------------
    |
   */
    'auth_key' => env('ONESIGNAL_AUTH_KEY'),


    /*
    |-------------------------------------------------------------------------------------------
    | Timeout - One Signal have different timeout for every app.
    |
    | Based on App you are using, you can change the timeout here and specify here
    |-------------------------------------------------------------------------------------------
    |
   */
    'timeout' => env('ONESIGNAL_TIMEOUT', 10),

    /*
    |-------------------------------------------------------------------------------------------
    | use_fallback - Should onesignal write every job to database?
    |
    | fallback option for future errors
    |-------------------------------------------------------------------------------------------
    |
   */
    'use_fallback' => env('ONESIGNAL_USE_FALLBACK', false),

    /*
    |-------------------------------------------------------------------------------------------
    | Pool_size - Guzzle concurrent pool size
    |
    | This is the number of concurrent requests that will be sent at once on parallel requests.
    |-------------------------------------------------------------------------------------------
    |
    */
    'pool_size' => env('ONESIGNAL_POOL_SIZE', 10),
];
