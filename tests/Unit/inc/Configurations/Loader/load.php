<?php

namespace WPLaunchpad\HookExtractor\Tests\Unit\inc\Configurations\Loader;

use Mockery;
use WPLaunchpad\HookExtractor\Configurations\FactoryInterface;
use WPLaunchpad\HookExtractor\Configurations\Loader;
use League\Flysystem\Filesystem;
use WPLaunchpad\HookExtractor\ObjectValues\Folder;


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
     * @var Loader
     */
    protected $loader;

    public function set_up() {
        parent::set_up();
        $this->filesystem = Mockery::mock(Filesystem::class);
        $this->factory = Mockery::mock(FactoryInterface::class);
        $this->project_folder = Mockery::mock(Folder::class);
        $this->app_folder = Mockery::mock(Folder::class);

        $this->loader = new Loader($this->filesystem, $this->factory, $this->project_folder, $this->app_folder);
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldReturnAsExpected( $config, $expected )
    {
        $this->assertSame($expected['configurations'], $this->loader->load($config['path']));
    }
}
