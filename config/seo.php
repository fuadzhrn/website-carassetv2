<?php

/*
|--------------------------------------------------------------------------
| CarAsset — SEO Per Halaman (PROMPT 24)
|--------------------------------------------------------------------------
|
| Technical limits and canonical policy for the 5-page SEO module —
| tunable without touching controllers/services/rules.
*/

return [
    'title_max_length' => 70,
    'description_max_length' => 180,

    'recommended_title_length' => [
        'min' => 30,
        'max' => 60,
    ],

    'recommended_description_length' => [
        'min' => 120,
        'max' => 160,
    ],

    'canonical' => [
        // If false, ValidCanonicalUrl only accepts a host matching APP_URL.
        'allow_external_domain' => false,
        'allow_query_string' => false,
        'allow_fragment' => false,
        'require_https_in_production' => true,
    ],
];
