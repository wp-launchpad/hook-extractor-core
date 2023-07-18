<?php
return [
    'validValueShouldReturnSame' => [
        'config' => [
              'value' => 'prefix_test_',
              'is_valid' => true,
        ],
        'expected' => [
            'exception' => false,
            'value' => 'prefix_test_'
        ]
    ],
    'spaceValueShouldRaiseException' => [
        'config' => [
            'value' => 'prefix test_',
            'is_valid' => false,
        ],
        'expected' => [
            'exception' => true,
            'value' => 'value'
        ]
    ],
    'NonAsciiValueShouldRaiseException' => [
        'config' => [
            'value' => 'prefixétest_',
            'is_valid' => false,
        ],
        'expected' => [
            'exception' => true,
            'value' => 'value'
        ]
    ],
    'NumberValueShouldRaiseException' => [
        'config' => [
            'value' => 'prefix1test_',
            'is_valid' => false,
        ],
        'expected' => [
            'exception' => true,
            'value' => 'value'
        ]
    ],
    'SpecialCharacterValueShouldRaiseException' => [
        'config' => [
            'value' => 'prefix#test_',
            'is_valid' => false,
        ],
        'expected' => [
            'exception' => true,
            'value' => 'value'
        ]
    ],

];
