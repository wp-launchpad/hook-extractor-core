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

$content = file_get_contents(__DIR__ . '/template.tpl');

$node = $parser->parseSourceFile($content);

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
            ],
            'docblock' => []
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
                    'content' => $content
                ],
            ],
            'parse' => [
                $content => $node
            ],
            'docblock' => [
                [
                    'block' => '/**
         * Before an order succeed.
         * @param int $order_id Order ID.
         */',
                    'output' => [
                        'description' => 'Before an order succeed.',
                    ]
                ],
                [
                    'block' => '/**
         * After an order succeed.
         * @param int $order_id Order ID.
         */',
                    'output' => [
                        'description' => 'After an order succeed.',
                    ]
                ],
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
                            'line' => 64
                        ]
                    ],
                    'description' => 'Before an order succeed.',
                ],
                [
                    'type' => 'action',
                    'name' => '{$this->prefix}success_order_after',
                    'files' => [
                        [
                            'path' => 'inc/file.php',
                            'line' => 74
                        ]
                    ],
                    'description' => 'After an order succeed.',
                ],
                [
                        'type' => 'action',
                        'name' => '{$this->prefix}error_order_before',
                        'files' => [
                            [
                                'path' => 'inc/file.php',
                                'line' => 88
                            ]
                        ]
                ],

                [
                        'type' => 'action',
                        'name' => '{$this->prefix}error_order_after',
                        'files' => [
                            [
                                'path' => 'inc/file.php',
                                'line' => 97
                            ]
                        ]
                ],

                [
                        'type' => 'action',
                        'name' => '{$this->prefix}process_request_order_before',
                        'files' => [
                            [
                                'path' => 'inc/file.php',
                                'line' => 111
                            ]
                        ]
                ],
                [
                        'type' => 'action',
                        'name' => '{$this->prefix}process_request_order_after',
                        'files' => [
                            [
                                'path' => 'inc/file.php',
                                'line' => 113
                            ]
                        ]
                ],
                [
                        'type' => 'action',
                        'name' => '{$this->prefix}process_order_before',
                        'files' => [
                            [
                                'path' => 'inc/file.php',
                                'line' => 123
                            ]
                        ]
                ],
                [
                        'type' => 'filter',
                        'name' => '{$this->prefix}purchase_request_data',
                        'files' => [
                            [
                                'path' => 'inc/file.php',
                                'line' => 129
                            ]
                        ]
                ],
                [
                    'type' => 'filter',
                        'name' => '{$this->prefix}billing_address_data',
                        'files' => [
                            [
                                'path' => 'inc/file.php',
                                'line' => 156
                            ]
                        ]
                ],
                [
                        'type' => 'filter',
                        'name' => '{$this->prefix}shipping_address_data',
                        'files' => [
                            [
                                'path' => 'inc/file.php',
                                'line' => 175
                            ]
                        ]
                ],
                [
                        'type' => 'filter',
                        'name' => '{$this->prefix}client_data',
                        'files' => [
                            [
                                'path' => 'inc/file.php',
                                'line' => 192
                            ]
                        ]
                ],
                [
                        'type' => 'action',
                        'name' => '{$this->prefix}process_order_after',
                        'files' => [
                            [
                                'path' => 'inc/file.php',
                                'line' => 214
                            ]
                        ]
                ]
            ]
        ]
    ],
    'FoldersNotExistShouldReturnEmpty' => [
        'config' => [
            'configuration' => $folders_configuration,
            'exists' => [
                [
                    'path' => $inc_folder,
                    'exists' => false,
                ]
            ],
            'list' => [
            ],
            'content' => [

            ],
            'parse' => [

            ],
            'docblock' => []
        ],
        'expected' => [
            'results' => [

            ]
        ]
    ],
];
