<?php
return [
    'status' => [
        'n' => 'Inactive',
        'y' => 'Active',
    ],

    'months' => [
        '1'  => 'January',
        '2'  => 'February',
        '3'  => 'March',
        '4'  => 'April',
        '5'  => 'May',
        '6'  => 'June',
        '7'  => 'July',
        '8'  => 'August',
        '9'  => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December',
    ],
    
    'avatar' => [
        'public' => '/files/avatar/',
        'folder' => public_path() . '/files/avatar/',

        'image' => [
            'width'  => 160,
            'height' => 160,
        ]
    ],

    'images' => [
        'public' => '/files/team-logo/',
        'folder' => public_path() . '/files/team-logo/',

        'image' => [
            'width'  => 160,
            'height' => 160,
        ]
    ],

    /*
    |------------------------------------------------------------------------------------
    | ENV of APP
    |------------------------------------------------------------------------------------
    */
    'APP_ADMIN' => env('APP_ADMIN', 'admin'),
    'APP_TOKEN' => env('APP_TOKEN', 'admin123456'),
    
    'STATUS_ACTIVE'=>'y',
    'STATUS_INACTIVE'=>'n',

    'LIMIT'=>'10',
    'STATUS_ACTIVE' => 'Active',
    'STATUS_INACTIVE' => 'Inactive',
];
