<?php
return [
    'secret' => env('JWT_SECRET'),
    'algo' => env('JWT_ALGO', 'HS256'),
    'ttl' => env('JWT_TTL', 6 * 60 * 60 * 60), // 6 hours
];
?>