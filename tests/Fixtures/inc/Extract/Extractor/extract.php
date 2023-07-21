<?php

use Microsoft\PhpParser\Parser;
use WPLaunchpad\HookExtractor\Entities\Configuration;
use WPLaunchpad\HookExtractor\ObjectValues\Folder;
use WPLaunchpad\HookExtractor\ObjectValues\Path;

$configuration = new Configuration();

$inc_folder = new Folder('inc');

$file_path = new Path('inc/file.php');

$folders_configuration = new Configuration();
$folders_configuration->set_folders([
    $inc_folder,
]);

$parser = new Parser();

$node = $parser->parseSourceFile(file_get_contents(__DIR__ . '/template.tpl'));

return [
    'notFolderShouldReturnEmpty' => [
        'config' => [
              'configuration' => $configuration,
              'exists' => [
                  [
                      'path' => $inc_folder,
                      'exists' => true,
                  ]
              ],
              'list' => [
                  [
                      'path' => $inc_folder,
                      'listing' => []
                  ]
              ],
            'content' => [
            ],
            'parse' => [
            ]
        ],
        'expected' => [
            'results' => []
        ]
    ],
    'FoldersShouldReturnHooks' => [
        'config' => [
            'configuration' => $folders_configuration,
            'exists' => [
                [
                    'path' => $inc_folder,
                    'exists' => true,
                ]
            ],
            'list' => [
                [
                    'path' => $inc_folder,
                    'listing' => [
                        [
                            'type' => 'file',
                            'path' => $file_path
                        ]
                    ]
                ]
            ],
            'content' => [
                [
                    'path' => $file_path,
                    'content' => 'content'
                ],
            ],
            'parse' => [
                'content' => $node
            ]
        ],
        'expected' => [
            'results' => [

            ]
        ]
    ]
];
