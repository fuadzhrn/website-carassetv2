<?php

/*
|--------------------------------------------------------------------------
| CarAsset — Contact Form / Consultation Technical Limits
|--------------------------------------------------------------------------
|
| Technical limits only — no credentials, no contact data, no program
| options (those stay in CMS via config/about-contact-content.php +
| page_sections). Every value here is meant to be tunable without
| touching the controller/request classes that read it.
|
*/

return [
    'rate_limit' => [
        'max_attempts' => 5,
        'decay_minutes' => 10,
    ],

    'spam_protection' => [
        'honeypot' => true,
        'minimum_fill_seconds' => 3,
        'maximum_form_age_minutes' => 120,
    ],

    'privacy' => [
        'store_ip_address' => false,
        'store_user_agent' => false,
    ],

    'validation' => [
        'name_max' => 150,
        'whatsapp_max' => 30,
        'email_max' => 255,
        'message_min' => 10,
        'message_max' => 3000,
    ],

    'pagination' => 20,
];
