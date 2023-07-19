<?php

use WPLaunchpad\HookExtractor\ObjectValues\Folder;
use WPLaunchpad\HookExtractor\ObjectValues\Path;
use WPLaunchpad\HookExtractor\ObjectValues\Prefix;

return [
    'FullDataShouldReturnConfiguredInstance' => [
        'config' => [
              'data' => [
                  'includes' => [
                      'inc',
                      'classes',
                  ],
                  'excludes' => [
                      'inc/Dependencies',
                      'inc/classes/dependencies',
                  ],
                  'hooks' => [
                      'prefix' => [
                          'rocket_',
                          'launcher_'
                      ],
                      'excluded' => [
                          'excluded_',
                      ]
                  ]
              ],
        ],
        'expected' => [
            'folders' => [
                new Folder('inc'),
                new Folder('classes'),
            ],
            'exclusions' => [
                new Path('inc/Dependencies'),
                new Path('inc/classes/dependencies'),
            ],
            'prefixes' => [
                new Prefix('rocket_'),
                new Prefix('launcher_'),
            ],
            'hook_excluded' => [
                new Prefix('excluded_'),
            ]
        ]
    ],

];
