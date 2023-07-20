<?php

namespace WPLaunchpad\HookExtractor\Extract;

use Jasny\PhpdocParser\PhpdocParser;
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
        return [];
    }
}