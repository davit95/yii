<?php

return [
    [
        'id' => 1,
        'statistical_data_set_id' => 1,
        'name' => 'test_index',
        'attributes' => 'a:3:{i:0;a:2:{s:4:"name";s:5:"attr1";s:5:"group";i:1;}i:1;a:2:{s:4:"name";s:5:"attr2";s:4:"aggr";s:3:"SUM";}i:2;a:2:{s:4:"name";s:5:"attr3";s:4:"aggr";s:3:"MAX";}}',
        'description' => 'Test index'
    ],
    [
        'id' => 2,
        'statistical_data_set_id' => 3,
        'name' => 'times_credentials_used',
        'attributes' => 'a:4:{i:0;a:2:{s:4:"name";s:19:"content_provider_id";s:5:"group";b:1;}i:1;a:2:{s:4:"name";s:21:"content_provider_name";s:5:"group";b:1;}i:2;a:2:{s:4:"name";s:13:"credential_id";s:5:"group";b:1;}i:3;a:2:{s:4:"name";s:10:"times_used";s:4:"aggr";s:3:"SUM";}}',
        'description' => 'Number of times credential was used.'
    ]
];
