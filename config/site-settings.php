<?php

use Illuminate\Validation\Rule;

/*
|--------------------------------------------------------------------------
| CarAsset — Site Settings Definition
|--------------------------------------------------------------------------
|
| Satu-satunya sumber whitelist untuk key `site_settings` yang boleh
| dikelola admin. SiteSettingSeeder membaca ini untuk membuat baris
| kosong; UpdateSiteSettingsRequest & SiteSettingController membaca ini
| untuk validasi dan render form — admin TIDAK BISA menambah key bebas.
|
*/

return [
    'groups' => [
        'brand' => [
            'label' => 'Identitas Brand',
            'fields' => [
                'name' => [
                    'label' => 'Nama Brand',
                    'type' => 'text',
                    'default' => 'CarAsset',
                    'rules' => ['nullable', 'string', 'max:100'],
                ],
                'tagline' => [
                    'label' => 'Tagline',
                    'type' => 'text',
                    'default' => 'Mobil Bekerja. Aset Bertumbuh.',
                    'rules' => ['nullable', 'string', 'max:180'],
                ],
                'logo_horizontal' => [
                    'label' => 'Logo Horizontal',
                    'type' => 'media',
                    'default' => null,
                    'rules' => ['nullable', 'integer', 'exists:media,id'],
                ],
                'logo_on_dark' => [
                    'label' => 'Logo pada Background Gelap',
                    'type' => 'media',
                    'default' => null,
                    'rules' => ['nullable', 'integer', 'exists:media,id'],
                ],
                'favicon' => [
                    'label' => 'Favicon',
                    'type' => 'media',
                    'default' => null,
                    'rules' => ['nullable', 'integer', 'exists:media,id'],
                ],
            ],
        ],

        'contact' => [
            'label' => 'Informasi Kontak',
            'fields' => [
                'whatsapp' => [
                    'label' => 'Nomor WhatsApp',
                    'type' => 'phone',
                    'default' => null,
                    'rules' => ['nullable', 'string', 'max:30'],
                ],
                'email' => [
                    'label' => 'Email',
                    'type' => 'email',
                    'default' => null,
                    'rules' => ['nullable', 'email', 'max:255'],
                ],
                'address' => [
                    'label' => 'Alamat',
                    'type' => 'textarea',
                    'default' => null,
                    'rules' => ['nullable', 'string', 'max:1000'],
                ],
                'business_hours' => [
                    'label' => 'Jam Layanan',
                    'type' => 'text',
                    'default' => null,
                    'rules' => ['nullable', 'string', 'max:255'],
                ],
            ],
        ],

        'footer' => [
            'label' => 'Footer',
            'fields' => [
                'description' => [
                    'label' => 'Deskripsi Footer',
                    'type' => 'textarea',
                    'default' => null,
                    'rules' => ['nullable', 'string', 'max:1000'],
                ],
                'copyright' => [
                    'label' => 'Teks Copyright',
                    'type' => 'text',
                    'default' => null,
                    'rules' => ['nullable', 'string', 'max:255'],
                ],
            ],
        ],

        'social' => [
            'label' => 'Media Sosial',
            'fields' => [
                'instagram' => [
                    'label' => 'Instagram',
                    'type' => 'url',
                    'default' => null,
                    'rules' => ['nullable', 'url', 'max:500'],
                ],
                'facebook' => [
                    'label' => 'Facebook',
                    'type' => 'url',
                    'default' => null,
                    'rules' => ['nullable', 'url', 'max:500'],
                ],
                'linkedin' => [
                    'label' => 'LinkedIn',
                    'type' => 'url',
                    'default' => null,
                    'rules' => ['nullable', 'url', 'max:500'],
                ],
                'youtube' => [
                    'label' => 'YouTube',
                    'type' => 'url',
                    'default' => null,
                    'rules' => ['nullable', 'url', 'max:500'],
                ],
                'tiktok' => [
                    'label' => 'TikTok',
                    'type' => 'url',
                    'default' => null,
                    'rules' => ['nullable', 'url', 'max:500'],
                ],
            ],
        ],

        'seo' => [
            'label' => 'SEO Default',
            'fields' => [
                'default_title' => [
                    'label' => 'Meta Title Default',
                    'type' => 'text',
                    'default' => 'CarAsset — Mobil Bekerja. Aset Bertumbuh.',
                    'rules' => ['nullable', 'string', 'max:70'],
                ],
                'default_description' => [
                    'label' => 'Meta Description Default',
                    'type' => 'textarea',
                    'default' => null,
                    'rules' => ['nullable', 'string', 'max:180'],
                ],
                'default_robots' => [
                    'label' => 'Robots Default',
                    'type' => 'select',
                    'options' => [
                        'index,follow' => 'index, follow',
                        'noindex,nofollow' => 'noindex, nofollow',
                    ],
                    'default' => 'index,follow',
                    // Rule::in() (bukan "in:a,b") karena nilai yang sah sendiri
                    // mengandung koma — "in:" string akan salah memecahnya jadi
                    // 4 nilai terpisah.
                    'rules' => ['nullable', Rule::in(['index,follow', 'noindex,nofollow'])],
                ],
            ],
        ],

        'site' => [
            'label' => 'Status Data Website',
            'fields' => [
                'data_status' => [
                    'label' => 'Status Data Website',
                    'type' => 'select',
                    'options' => [
                        'draft' => 'Masih Menunggu Konfirmasi',
                        'confirmed' => 'Telah Dikonfirmasi',
                    ],
                    'default' => 'draft',
                    'rules' => ['nullable', 'in:draft,confirmed'],
                ],
                'data_status_message' => [
                    'label' => 'Catatan Status Data',
                    'type' => 'textarea',
                    'default' => null,
                    'rules' => ['nullable', 'string', 'max:500'],
                ],
            ],
        ],
    ],
];
