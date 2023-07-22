<?php

namespace WPLaunchpad\HookExtractor\Extract;

use Exception;
use Jasny\PhpdocParser\PhpdocException;
use Jasny\PhpdocParser\PhpdocParser;
use Microsoft\PhpParser\Node;
use Microsoft\PhpParser\Node\Expression\CallExpression;
use Microsoft\PhpParser\Node\Statement\ExpressionStatement;
use Microsoft\PhpParser\Parser;
use WPLaunchpad\HookExtractor\Entities\Configuration;
use WPLaunchpad\HookExtractor\Filesystem\FilesystemInterface;

class Extractor
{
    /**
     * PHP Parser.
     *
     * @var Parser
     */
    protected $parser;

    /**
     * Docblock parser.
     *
     * @var PhpdocParser
     */
    protected $doc_parser;

    /**
     * Filesystem.
     *
     * @var FilesystemInterface
     */
    protected $filesystem;

    /**
     * Instantiate the extractor.
     *
     * @param Parser $parser PHP Parser.
     * @param PhpdocParser $doc_parser Docblock parser.
     * @param FilesystemInterface $filesystem Filesystem.
     */
    public function __construct(Parser $parser, PhpdocParser $doc_parser, FilesystemInterface $filesystem)
    {
        $this->parser = $parser;
        $this->doc_parser = $doc_parser;
        $this->filesystem = $filesystem;
    }

    /**
     * Extract hooks.
     *
     * @param Configuration $configuration Hook extractor configurations.
     * @return array
     * @throws Exception
     */
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
                                    'line' => $this->find_line($child_node->getStartPosition(), $content),
                                ]
                            ],
                        ];


                        $data = $this->get_doc_node($child_node);
                        $extract = array_merge( $extract, $data );

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
                                    'line' => $this->find_line($child_node->getStartPosition(), $content),
                                ]
                            ],
                        ];

                        $data = $this->get_doc_node($child_node);
                        $extract = array_merge( $extract, $data );

                        $extracts [] = $extract;
                    }
                }
            }
        }
        return $extracts;
    }

    /**
     * Find the line number from a position.
     *
     * @param int $position Position to set the line number for.
     * @param string $content Content to search lines in.
     * @return int
     */
    protected function find_line(int $position, string $content) {

        $content = preg_replace('/\R/u', "\n", $content);
        $content = substr($content, 0, $position);
        return substr_count( $content, "\n" ) + 1;
    }

    /**
     * Get the docblock of the node.
     *
     * @param Node $node Node to search on.
     * @return array
     */
    protected function get_doc_node(Node $node): array {
        while ($node && ! $node instanceof ExpressionStatement) {
            $children = $node->getChildNodes();
            foreach ($children as $child) {
                $doc = $child->getDocCommentText();
                if($doc) {
                    try {
                        return $this->doc_parser->parse($doc);
                    } catch (PhpdocException $exception) {
                        return [];
                    }
                }
            }

            $node = $node->getParent();
        }

        return [];
    }
}