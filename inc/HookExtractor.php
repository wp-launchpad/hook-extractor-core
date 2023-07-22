<?php

namespace WPLaunchpad\HookExtractor;

use Jasny\PhpdocParser\PhpdocParser;
use Jasny\PhpdocParser\Set\PhpDocumentor;
use Jasny\PhpdocParser\Tag\Summery;
use Microsoft\PhpParser\Parser;
use WPLaunchpad\HookExtractor\Entities\Configuration;
use WPLaunchpad\HookExtractor\Extract\Extractor;
use WPLaunchpad\HookExtractor\Filesystem\FilesystemInterface;

class HookExtractor
{

    /**
     * Filesystem.
     *
     * @var FilesystemInterface
     */
    protected $filesystem;

    /**
     * Hook extractor.
     *
     * @var Extractor
     */
    protected $extractor;

    /**
     * Instantiate facade.
     *
     * @param FilesystemInterface $filesystem Filesystem.
     */
    public function __construct(FilesystemInterface $filesystem, PhpdocParser $php_parser = null, Parser $docblock_parser = null)
    {
        $this->filesystem = $filesystem;

        if( ! $docblock_parser ) {
            $tags = PhpDocumentor::tags()->with([new Summery()]);
            $docblock_parser = new PHPDocParser($tags);
        }

        $this->extractor  = new Extractor($php_parser ?: new Parser(), $docblock_parser, $filesystem);
    }


    /**
     * Extract hooks.
     *
     * @param Configuration $configuration Extractor configurations.
     *
     * @return array
     */
    public function extract(Configuration $configuration): array {
        return $this->extractor->extract($configuration);
    }
}