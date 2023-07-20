<?php
return [
    'validValueShouldReturnSame' => [
        'config' => [
              'value' => '/path/test/',
              'is_valid' => true,
        ],
        'expected' => [
            'exception' => false,
            'value' => '/path/test/'
        ]
    ],
    'fileShouldReturnSame' => [
        'config' => [
            'value' => '/path/test/test.php',
        ],
        'expected' => [
            'exception' => false,
            'value' => '/path/test/test.php'
        ]
    ],
    'notRootShouldReturnSame' => [
        'config' => [
            'value' => 'path/test/test.php',
        ],
        'expected' => [
            'exception' => false,
            'value' => 'path/test/test.php'
        ]
    ],
    'invalidValueShouldRaiseException' => [
        'config' => [
            'value' => 'http://test.test',
            'is_valid' => false,
        ],
        'expected' => [
            'exception' => true,
            'value' => 'http://test.test'
        ]
    ],

];
