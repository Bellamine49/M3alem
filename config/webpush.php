<?php

return [
    'vapid' => [
        'subject' => env('VAPID_SUBJECT', 'mailto:contact@m3alem.ma'),
        'public_key' => env('VAPID_PUBLIC_KEY', ''),
        'private_key' => env('VAPID_PRIVATE_KEY', ''),
    ],
];
