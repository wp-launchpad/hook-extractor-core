<?php

namespace WPLaunchpad\HookExtractor\Tests\Unit\inc\Extract\Extractor;

use Microsoft\PhpParser\Parser;
use Mockery;
use WPLaunchpad\HookExtractor\Extract\Extractor;
use Jasny\PhpdocParser\PhpdocParser;
use WPLaunchpad\HookExtractor\Filesystem\FilesystemInterface;


use WPLaunchpad\HookExtractor\Tests\Unit\TestCase;

/**
 * @covers \WPLaunchpad\HookExtractor\Extract\Extractor::extract
 */
class Test_extract extends TestCase {

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
     * @var Extractor
     */
    protected $extractor;

    public function set_up() {
        parent::set_up();
        $this->parser = Mockery::mock(Parser::class);
        $this->doc_parser = Mockery::mock(PhpdocParser::class);
        $this->filesystem = Mockery::mock(FilesystemInterface::class);

        $this->extractor = new Extractor($this->parser, $this->doc_parser, $this->filesystem);
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldReturnAsExpected( $config, $expected )
    {
        foreach ($config['exists'] as $exist) {
            $this->filesystem->expects()->exists($exist['path'])->andReturn($exist['exists']);
        }

        foreach ($config['list'] as $list) {
            $this->filesystem->expects()->list($list['path'], true)->andReturn($list['listing']);
        }

        foreach ($config['content'] as $content) {
            $this->filesystem->expects()->get_content($content['path'])->andReturn($content['content']);
        }

        foreach ($config['parse'] as $content => $parsed) {
            $this->parser->expects()->parseSourceFile($content)->andReturn($parsed);
        }

        foreach ($config['docblock'] as $docblock) {
            $this->doc_parser->expects()->parse($docblock['block'])->andReturn($docblock['output']);
        }

        $this->assertSame($expected['results'], $this->extractor->extract($config['configuration']));
    }
}
