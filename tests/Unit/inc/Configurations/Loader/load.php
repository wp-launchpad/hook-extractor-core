<?php

namespace WPLaunchpad\HookExtractor\Tests\Unit\inc\Configurations\Loader;

use Mockery;
use WPLaunchpad\HookExtractor\Configurations\FactoryInterface;
use WPLaunchpad\HookExtractor\Configurations\Loader;
use League\Flysystem\Filesystem;
use WPLaunchpad\HookExtractor\Filesystem\FilesystemInterface;
use WPLaunchpad\HookExtractor\ObjectValues\Folder;


use WPLaunchpad\HookExtractor\ObjectValues\ObjectValueFactory;
use WPLaunchpad\HookExtractor\Tests\Unit\TestCase;

/**
 * @covers \WPLaunchpad\HookExtractor\Configurations\Loader::load
 */
class Test_load extends TestCase {

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * @var Folder
     */
    protected $project_folder;

    /**
     * @var Folder
     */
    protected $app_folder;

    /**
     * @var ObjectValueFactory
     */
    protected $object_value_factory;

    /**
     * @var Loader
     */
    protected $loader;

    public function set_up() {
        parent::set_up();
        $this->filesystem = Mockery::mock(FilesystemInterface::class);
        $this->factory = Mockery::mock(FactoryInterface::class);
        $this->project_folder = Mockery::mock(Folder::class);
        $this->app_folder = Mockery::mock(Folder::class);
        $this->object_value_factory = Mockery::mock(ObjectValueFactory::class);

        $this->loader = new Loader($this->filesystem, $this->factory, $this->object_value_factory, $this->project_folder, $this->app_folder);
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldReturnAsExpected( $config, $expected )
    {

        $this->project_folder->allows()->get_value()->andReturn($config['project_folder']);

        foreach ($config['create_path'] as $path => $instance) {
            $this->object_value_factory->expects()->create_path($path)->andReturn($instance);
        }

        foreach ($config['exists'] as $exist) {
            $this->filesystem->expects()->exists($exist['path'])->andReturn($exist['exists']);
        }

        foreach ($config['content'] as $content) {
            $this->filesystem->expects()->get_content($content['path'])->andReturn($content['content']);
        }

        $this->factory->expects()->make($expected['data'])->andReturn($config['configurations']);

        $this->assertSame($expected['configurations'], $this->loader->load($config['path']));
    }
}
