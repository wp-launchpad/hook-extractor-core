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
    'fileShouldRaiseException' => [
        'config' => [
            'value' => '/path/test/test.php',
        ],
        'expected' => [
            'exception' => true,
            'value' => '/path/test/test.php'
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
