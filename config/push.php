<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Push Notifications
    |--------------------------------------------------------------------------
    |
    | Global FCM push notification settings. Firebase service account JSON is
    | stored in the `firebase_credentials` database table (not the filesystem).
    |
    */

    'enabled' => env('PUSH_NOTIFICATIONS_ENABLED', true),

    'topic_prefix' => env('PUSH_TOPIC_PREFIX', 'org'),

];
