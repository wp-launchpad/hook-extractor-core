<?php

use WPLaunchpad\HookExtractor\ObjectValues\Folder;
use WPLaunchpad\HookExtractor\ObjectValues\Path;
use WPLaunchpad\HookExtractor\ObjectValues\Prefix;

$inc_folder = new Folder('inc');
$classes_folder = new Folder('classes');

$inc_path = new Path('inc/Dependencies');
$classes_path = new Path('inc/classes/dependencies');

$rocket_prefix = new Prefix('rocket_');
$launcher_prefix = new Prefix('launcher_');
$excluded_prefix = new Prefix('excluded_');

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
                'folders' => [
                        'inc' => $inc_folder,
                        'classes' => $classes_folder,
                  ],
                  'paths' => [
                        'inc/Dependencies' => $inc_path,
                        'inc/classes/dependencies' => $classes_path,
                  ],
                  'prefixes' => [
                        'rocket_' => $rocket_prefix,
                        'launcher_' => $launcher_prefix,
                        'excluded_' => $excluded_prefix
                  ],
        ],
        'expected' => [
            'folders' => [
                $inc_folder,
                $classes_folder,
            ],
            'exclusions' => [
                $inc_path,
                $classes_path,
            ],
            'prefixes' => [
                $rocket_prefix,
                $launcher_prefix,
            ],
            'hook_excluded' => [
                $excluded_prefix,
            ]
        ]
    ],
    'MissingExcludesReturnConfiguredInstance' => [
        'config' => [
            'data' => [
                'includes' => [
                    'inc',
                    'classes',
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
            'folders' => [
                'inc' => $inc_folder,
                'classes' => $classes_folder,
            ],
            'paths' => [],
            'prefixes' => [
                'rocket_' => $rocket_prefix,
                'launcher_' => $launcher_prefix,
                'excluded_' => $excluded_prefix
            ],
        ],
        'expected' => [
            'folders' => [
                $inc_folder,
                $classes_folder,
            ],
            'exclusions' => [
            ],
            'prefixes' => [
                $rocket_prefix,
                $launcher_prefix,
            ],
            'hook_excluded' => [
                $excluded_prefix,
            ]
        ]
    ],

];