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
    'validValueWithoutSlashShouldReturnSame' => [
        'config' => [
            'value' => 'path',
        ],
        'expected' => [
            'exception' => false,
            'value' => 'path'
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
    'invalidValueShouldReturnSame' => [
        'config' => [
            'value' => 'valué',
        ],
        'expected' => [
            'exception' => false,
            'value' => 'valué'
        ]
    ],

];
