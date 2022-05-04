<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAA-ii8PJM:APA91bG-Yg9_3ilHaUba9ED8WSUXOBEcRRRty-b7gwTEgoY6ivYlBrdYSpBkElF8CUALgwmL6apdjilk7Tr5JL3UlG6orkqbDHjgXp2glJYmmilJX8lfMLf2NuiKVrkT9Y6fuIk8rE1IKdz7BykCrHDxdLdqZvWz7Q'),
        'sender_id' => env('FCM_SENDER_ID', '1074425248915'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
