<?php

use WPLaunchpad\HookExtractor\Entities\Configuration;
use WPLaunchpad\HookExtractor\ObjectValues\Path;

$configurations = new Configuration();
$path = new Path('/path/');
return [
    'LoadingPathConfigurationShouldReturnConfiguration' => [
        'config' => [
            'path' => $path,
            'exists' => [
                [
                    'path' => $path,
                    'exists' => true
                ]
            ],
            'content' => [
                [
                    'path' => $path,
                    'content' => file_get_contents(__DIR__ . '/content.yaml')
                ]
            ],
            'configurations' => $configurations,
        ],
        'expected' => [
            'data' => yaml_parse_file(__DIR__ . '/content.yaml'),
            'configurations' => $configurations
        ]
    ],

];
