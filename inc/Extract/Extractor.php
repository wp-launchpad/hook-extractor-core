<?php

namespace WPLaunchpad\HookExtractor\Extract;

use Jasny\PhpdocParser\PhpdocParser;
use Microsoft\PhpParser\Node\Expression\CallExpression;
use Microsoft\PhpParser\Parser;
use WPLaunchpad\HookExtractor\Entities\Configuration;
use WPLaunchpad\HookExtractor\Filesystem\FilesystemInterface;

class Extractor
{
    /**
     * @var Parser
     */
    protected $parser;

    /**
     * @var PhpdocParser
     */
    protected $doc_parser;

    /**
     * @var FilesystemInterface
     */
    protected $filesystem;

    /**
     * @param Parser $parser
     * @param PhpdocParser $doc_parser
     * @param FilesystemInterface $filesystem
     */
    public function __construct(Parser $parser, PhpdocParser $doc_parser, FilesystemInterface $filesystem)
    {
        $this->parser = $parser;
        $this->doc_parser = $doc_parser;
        $this->filesystem = $filesystem;
    }

    public function extract(Configuration $configuration): array {
        $folders = $configuration->get_folders();
        $extracts = [];
        foreach ($folders as $folder) {
            if(! $this->filesystem->exists($folder)) {
                continue;
            }
            foreach ($this->filesystem->list($folder, true) as $path) {
                $content = $this->filesystem->get_content($path['path']);
                $node = $this->parser->parseSourceFile($content);

                foreach ($node->getDescendantNodes() as $child_node) {
                    if ( $child_node instanceof CallExpression && $child_node->callableExpression->getText() === 'do_action') {
                        $parameters = explode(',', $child_node->argumentExpressionList->getText());

                        if(count($parameters) === 0) {
                            continue;
                        }

                        $name = trim( trim(array_shift($parameters)), '\'"');

                        $extract = [
                            'type' => 'action',
                            'name' => $name,
                            'files' => [
                                [
                                    'path' => $path['path']->get_value(),
                                    'line' => $child_node->getStartPosition(),
                                ]
                            ],
                        ];

                        $extracts [] = $extract;
                    }
                    if ( $child_node instanceof CallExpression && $child_node->callableExpression->getText() === 'apply_filters') {
                        $parameters = explode(',', $child_node->argumentExpressionList->getText());

                        if(count($parameters) === 0) {
                            continue;
                        }

                        $name = trim( trim(array_shift($parameters)), '\'"');

                        $extract = [
                            'type' => 'filter',
                            'name' => $name,
                            'files' => [
                                [
                                    'path' => $path['path']->get_value(),
                                    'line' => $child_node->getStartPosition(),
                                ]
                            ],
                        ];

                        $extracts [] = $extract;
                    }
                }
            }
        }
        return $extracts;
    }
}