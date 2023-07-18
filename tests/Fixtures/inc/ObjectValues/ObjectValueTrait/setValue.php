<?php
return [
    'validValueShouldReturnSame' => [
        'config' => [
              'value' => 'value',
              'is_valid' => true,
        ],
        'expected' => [
            'exception' => false,
            'value' => 'value'
        ]
    ],
    'invalidValueShouldRaiseException' => [
        'config' => [
            'value' => 'value',
            'is_valid' => false,
        ],
        'expected' => [
            'exception' => true,
            'value' => 'value'
        ]
    ],

];
