<?php

return [
    'disk' => 'public',
    'directory' => 'media',
    'max_size_kb' => 5120,
    'allowed_mimes' => [
        'jpg',
        'jpeg',
        'png',
        'webp',
    ],
    'allowed_mime_types' => [
        'image/jpeg',
        'image/png',
        'image/webp',
    ],
    'max_width' => 6000,
    'max_height' => 6000,
];
