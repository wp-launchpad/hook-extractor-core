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
     * @var FilesystemInterface
     */
    protected $filesystem;

    /**
     * @var Extractor
     */
    protected $extractor;

    /**
     * @param FilesystemInterface $filesystem
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


    public function extract(Configuration $configuration): array {
        return $this->extractor->extract($configuration);
    }
}