<?php
return [
    'validValueShouldReturnSame' => [
        'config' => [
              'value' => '/path/test/',
        ],
        'expected' => [
            'exception' => false,
            'value' => 'value'
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
