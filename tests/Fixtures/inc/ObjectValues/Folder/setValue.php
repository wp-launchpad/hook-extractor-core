<?php
return [
    'validValueShouldReturnSame' => [
        'config' => [
              'value' => '/path/test/',
        ],
        'expected' => [
            'exception' => false,
            'value' => '/path/test/'
        ]
    ],
    'invalidValueShouldRaiseException' => [
        'config' => [
            'value' => 'valué',
        ],
        'expected' => [
            'exception' => true,
            'value' => 'value'
        ]
    ],

];
