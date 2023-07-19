<?php

use WPLaunchpad\HookExtractor\Entities\Configuration;
use WPLaunchpad\HookExtractor\ObjectValues\Path;

$configurations = new Configuration();
$path = new Path('/path/');
$project_path = new Path('/project/path');
$app_path = new Path('/app/path');

return [
    'LoadingPathConfigurationShouldReturnConfiguration' => [
        'config' => [
            'project_folder' => '/project/path',
            'app_folder' => '/app/path',
            'path' => $path,
            'create_path' => [
                '/project/path/hook-extractor.yml' => $project_path,
                '/app/path/configs/default.yml' => $app_path,
            ],
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
    'LoadingPathConfigurationNotExistingShouldReturnProjectConfiguration' => [
        'config' => [
            'project_folder' => '/project/path',
            'app_folder' => '/app/path',
            'path' => $path,
            'create_path' => [
                '/project/path/hook-extractor.yml' => $project_path,
                '/app/path/configs/default.yml' => $app_path,
            ],
            'exists' => [
                [
                    'path' => $path,
                    'exists' => false
                ],
                [
                    'path' => $project_path,
                    'exists' => true,
                ]
            ],
            'content' => [
                [
                    'path' => $project_path,
                    'content' => file_get_contents(__DIR__ . '/content.yaml')
                ],
            ],
            'configurations' => $configurations,
        ],
        'expected' => [
            'data' => yaml_parse_file(__DIR__ . '/content.yaml'),
            'configurations' => $configurations
        ]
    ],
    'LoadingPathConfigurationNoContentShouldReturnProjectConfiguration' => [
        'config' => [
            'project_folder' => '/project/path',
            'app_folder' => '/app/path',
            'path' => $path,
            'create_path' => [
                '/project/path/hook-extractor.yml' => $project_path,
                '/app/path/configs/default.yml' => $app_path,
            ],
            'exists' => [
                [
                    'path' => $path,
                    'exists' => true
                ],
                [
                    'path' => $project_path,
                    'exists' => true,
                ]
            ],
            'content' => [
                [
                    'path' => $path,
                    'content' => ''
                ],
                [
                    'path' => $project_path,
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
    'LoadingPathConfigurationInvalidYamlShouldReturnProjectConfiguration' => [
        'config' => [
            'project_folder' => '/project/path',
            'app_folder' => '/app/path',
            'path' => $path,
            'create_path' => [
                '/project/path/hook-extractor.yml' => $project_path,
                '/app/path/configs/default.yml' => $app_path,
            ],
            'exists' => [
                [
                    'path' => $path,
                    'exists' => true
                ],
                [
                    'path' => $project_path,
                    'exists' => true,
                ]
            ],
            'content' => [
                [
                    'path' => $path,
                    'content' => 'aaa'
                ],
                [
                    'path' => $project_path,
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
    'LoadingProjectPathConfigurationNotExistingShouldReturnAppConfiguration' => [
        'config' => [
            'project_folder' => '/project/path',
            'app_folder' => '/app/path',
            'path' => $path,
            'create_path' => [
                '/project/path/hook-extractor.yml' => $project_path,
                '/app/path/configs/default.yml' => $app_path,
            ],
            'exists' => [
                [
                    'path' => $path,
                    'exists' => false
                ],
                [
                    'path' => $project_path,
                    'exists' => false,
                ],
                [
                    'path' => $app_path,
                    'exists' => true,
                ],
            ],
            'content' => [
                [
                    'path' => $app_path,
                    'content' => file_get_contents(__DIR__ . '/content.yaml')
                ],
            ],
            'configurations' => $configurations,
        ],
        'expected' => [
            'data' => yaml_parse_file(__DIR__ . '/content.yaml'),
            'configurations' => $configurations
        ]
    ],
];
