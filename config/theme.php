<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Theme Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default theme for your application.
    |
    */

    'name' => env('USED_TEMPLATE','metronic'),

    /*
    |--------------------------------------------------------------------------
    | Theme Layouts
    |--------------------------------------------------------------------------
    |
    | Here you may specify the layouts location for your theme.
    |
    */

    // 'layouts' => 'layouts.templates.'.env('USED_TEMPLATE','metronic'),
    'layouts' => [
        'admin' => 'layouts.templates.'.env('ADMIN_TEMPLATE', 'metronic').'.admin',
    ],

    /*
    |--------------------------------------------------------------------------
    | Theme Components
    |--------------------------------------------------------------------------
    |
    | Here you may specify the components location for your theme.
    |
    */

    'components' => 'components.'.env('USED_TEMPLATE','metronic'),

    /*
    |--------------------------------------------------------------------------
    | Theme Assets
    |--------------------------------------------------------------------------
    |
    | Asset list for theme
    |
    */

    'assets' => [
        'back-office' => 'templates/metronic-back-office/',
        'front-page' => 'templates/metronic-front-page/',
    ]

];
