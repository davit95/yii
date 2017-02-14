<?php

return [
    [
        'id' => 1,
        'name' => 'Test content number 1',
        'class' => 'service\\components\\contents\\BaseContent',
        'url_tpl' => 'http:\/\/.*\/tests\/codeception\/service\/_content\/.*',
        'auth_url' => NULL,
        'downloadable' => 1,
        'streamable' => 1,
        'storable' => 1,
        'use_proxy' => 0,
        'status' => 'ACTIVE',
        'created' => time(),
        'updated' => null
    ],
    [
        'id' => 2,
        'name' => 'Test content number 2',
        'class' => 'service\\components\\contents\\BaseContent',
        'url_tpl' => '.*',
        'auth_url' => NULL,
        'downloadable' => 1,
        'streamable' => 1,
        'storable' => 1,
        'use_proxy' => 0,
        'status' => 'INACTIVE',
        'created' => time(),
        'updated' => null
    ],
    [
        'id' => 3,
        'name' => 'Test content number 3',
        'class' => 'service\\components\\contents\\BaseContent',
        'url_tpl' => 'this does not math any url',
        'auth_url' => NULL,
        'downloadable' => 1,
        'streamable' => 1,
        'storable' => 1,
        'use_proxy' => 0,
        'status' => 'INACTIVE',
        'created' => time(),
        'updated' => null
    ],
    [
        'id' => 4,
        'name' => 'Test content number 4',
        'class' => 'service\\components\\contents\\BaseContent',
        'url_tpl' => 'this does not math any url',
        'auth_url' => NULL,
        'downloadable' => 1,
        'streamable' => 1,
        'storable' => 1,
        'use_proxy' => 0,
        'status' => 'INACTIVE',
        'created' => time(),
        'updated' => null
    ],
    [
        'id' => 5,
        'name' => 'Test content number 5',
        'class' => 'service\\components\\contents\\BaseContent',
        'url_tpl' => 'this does not math any url',
        'auth_url' => NULL,
        'downloadable' => 1,
        'streamable' => 1,
        'storable' => 1,
        'use_proxy' => 0,
        'status' => 'INACTIVE',
        'created' => time(),
        'updated' => null        
    ]
];
