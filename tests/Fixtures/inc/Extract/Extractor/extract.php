<?php

use WPLaunchpad\HookExtractor\Entities\Configuration;

$configuration = new Configuration();

return [
    'notFolderShouldReturnEmpty' => [
        'config' => [
              'configuration' => $configuration,
        ],
        'expected' => [
            'results' => []
        ]
    ],

];
