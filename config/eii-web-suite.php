<?php

return [
    'modules' => [
        'news' => true,
        'events' => true,
        'recruitment' => true,
        'faqs' => true,
        'blog' => false,
        'contact' => true,
        'seo' => true,
    ],

    'filament_resources' => (bool) env('EII_FILAMENT_RESOURCES', true),
];
