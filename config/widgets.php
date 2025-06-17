<?php

return [
    'discord' => [
        'enabled' => false,
        'server_id' => '1004443821570019338',
        'channel_id' => '1374482240427528254',
        'theme' => 'dark', //dark, light
    ],
    'globals_history' => [
        'enabled' => false,
        'limit' => 5,
    ],
    'unique_history' => [
        'enabled' => false,
        'limit' => 5,
    ],
    'top_player' => [
        'enabled' => false,
        'limit' => 5,
    ],
    'top_guild' => [
        'enabled' => false,
        'limit' => 5,
    ],
    'server_info' => [
        'enabled' => false,
        'data' => [
            0 => [
                //To changing icon https://fontawesome.com/icons
                'icon' => '<i class="fas fa-fw fa-check"></i>',
                'name' => 'Cap',
                'value' => '140'
            ],
            1 => [
                'icon' => '<i class="fa fa-fw fa-flask"></i>',
                'name' => 'EXP & SP',
                'value' => '1x'
            ],
            2 => [
                'icon' => '<i class="fa fa-fw fa-users"></i>',
                'name' => 'Party EXP',
                'value' => '1x'
            ],
            3 => [
                'icon' => '<i class="fa fa-fw fa-coins"></i>',
                'name' => 'Gold',
                'value' => '1x'
            ],
            4 => [
                'icon' => '<i class="fa fa-fw fa-coins"></i>',
                'name' => 'Drop',
                'value' => '1x'
            ],
            5 => [
                'icon' => '<i class="fa fa-fw fa-star"></i>',
                'name' => 'Trade goods',
                'value' => '1x'
            ],
            6 => [
                'icon' => '<i class="fa fa-fw fa-exclamation"></i>',
                'name' => 'HWID Limit',
                'value' => '1'
            ],
            7 => [
                'icon' => '<i class="fa fa-fw fa-exclamation"></i>',
                'name' => 'IP Limit',
                'value' => '1'
            ],
        ],
    ],
    'event_schedule' => [
        'enabled' => false,
        'names' => [
            10 => 'Roc',
            9 => 'Medusa',
            2 => 'Special Trade',
            4 => 'Fortress War',
            12 => 'Selket & Neith',
            13 => 'Anubis & Isis',
            14 => 'Haroeris & Seth',
            7 => 'Capture The Flag (CTF)',
            17 => 'Battle Arena (Random)',
            19 => 'Battle Arena (Party)',
            21 => 'Battle Arena (Guild)',
            23 => 'Battle Arena (Job)',
            50 => 'Survival (Solo)',
            49 => 'Survival (Party)',
        ],
    ],
    'fortress_war' => [
        'enabled' => false,
        'names' => [
            1 => [
                'name' => 'Jangan',
                'image' => 'images/sro/etc/fort_jangan.png',
            ],
            3 => [
                'name' => 'Hotan',
                'image' => 'images/sro/etc/fort_hotan.png',
            ],
            4 => [
                'name' => 'Constantinople',
                'image' => 'images/sro/etc/fort_constantinople.png',
            ],
            6 => [
                'name' => 'Bandit',
                'image' => 'images/sro/etc/fort_bijeokdan.png',
            ],
        ],
    ],
];
