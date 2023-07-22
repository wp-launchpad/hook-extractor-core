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
              ],
              'list' => [
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
                [
                    'type' => 'action',
                    'name' => '{$this->prefix}success_order_before',
                    'files' => [
                        [
                            'path' => 'inc/file.php',
                            'line' => 61
                        ]
                    ]
                ],
                [
                    'type' => 'action',
                    'name' => '{$this->prefix}success_order_after',
                    'files' => [
                        [
                            'path' => 'inc/file.php',
                            'line' => 68
                        ]
                    ]
                ],
                [
                        'type' => 'action',
                        'name' => '{$this->prefix}error_order_before',
                        'files' => [
                            [
                                'path' => 'inc/file.php',
                                'line' => 82
                            ]
                        ]
                ],

                [
                        'type' => 'action',
                        'name' => '{$this->prefix}error_order_after',
                        'files' => [
                            [
                                'path' => 'inc/file.php',
                                'line' => 91
                            ]
                        ]
                ],

                [
                        'type' => 'action',
                        'name' => '{$this->prefix}process_request_order_before',
                        'files' => [
                            [
                                'path' => 'inc/file.php',
                                'line' => 105
                            ]
                        ]
                ],
                [
                        'type' => 'action',
                        'name' => '{$this->prefix}process_request_order_after',
                        'files' => [
                            [
                                'path' => 'inc/file.php',
                                'line' => 107
                            ]
                        ]
                ],
                [
                        'type' => 'action',
                        'name' => '{$this->prefix}process_order_before',
                        'files' => [
                            [
                                'path' => 'inc/file.php',
                                'line' => 117
                            ]
                        ]
                ],
                [
                        'type' => 'filter',
                        'name' => '{$this->prefix}purchase_request_data',
                        'files' => [
                            [
                                'path' => 'inc/file.php',
                                'line' => 123
                            ]
                        ]
                ],
                [
                    'type' => 'filter',
                        'name' => '{$this->prefix}billing_address_data',
                        'files' => [
                            [
                                'path' => 'inc/file.php',
                                'line' => 150
                            ]
                        ]
                ],
                [
                        'type' => 'filter',
                        'name' => '{$this->prefix}shipping_address_data',
                        'files' => [
                            [
                                'path' => 'inc/file.php',
                                'line' => 169
                            ]
                        ]
                ],
                [
                        'type' => 'filter',
                        'name' => '{$this->prefix}client_data',
                        'files' => [
                            [
                                'path' => 'inc/file.php',
                                'line' => 186
                            ]
                        ]
                ],
                [
                        'type' => 'action',
                        'name' => '{$this->prefix}process_order_after',
                        'files' => [
                            [
                                'path' => 'inc/file.php',
                                'line' => 208
                            ]
                        ]
                ]
            ]
        ]
    ]
];
