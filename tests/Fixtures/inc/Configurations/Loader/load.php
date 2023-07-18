<?php

use WPLaunchpad\HookExtractor\Entities\Configuration;
use WPLaunchpad\HookExtractor\ObjectValues\Path;

$configurations = new Configuration();
$path = new Path('path');
return [
    'LoadingPathConfigurationShouldReturnConfiguration' => [
        'config' => [
            'path' => $path,
            'content' => [
                'path' => file_get_contents(__DIR__ . '/content.yaml')
            ],
            'configurations' => $configurations,
        ],
        'expected' => [
            'data' => [],
            'configurations' => $configurations
        ]
    ],

];
