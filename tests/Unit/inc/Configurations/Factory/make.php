<?php

namespace WPLaunchpad\HookExtractor\Tests\Unit\inc\Configurations\Factory;

use Mockery;
use WPLaunchpad\HookExtractor\Configurations\Factory;


use WPLaunchpad\HookExtractor\ObjectValues\ObjectValueFactoryInterface;
use WPLaunchpad\HookExtractor\Tests\Unit\TestCase;

/**
 * @covers \WPLaunchpad\HookExtractor\Configurations\Factory::make
 */
class Test_make extends TestCase {

    protected $object_value_factory;

    /**
     * @var Factory
     */
    protected $factory;

    public function set_up() {
        parent::set_up();

        $this->object_value_factory = Mockery::mock(ObjectValueFactoryInterface::class);

        $this->factory = new Factory($this->object_value_factory);
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldReturnAsExpected( $config, $expected )
    {
        foreach ($config['folders'] as $path => $folder) {
            $this->object_value_factory->expects()->create_folder($path)->andReturn($folder);
        }

        foreach ($config['paths'] as $path => $instance) {
            $this->object_value_factory->expects()->create_path($path)->andReturn($instance);
        }

        foreach ($config['prefixes'] as $prefix => $instance) {
            $this->object_value_factory->expects()->create_prefix($prefix)->andReturn($instance);
        }

        $configurations = $this->factory->make($config['data']);

        $this->assertEquals($expected['folders'], $configurations->get_folders());
        $this->assertEquals($expected['hook_excluded'], $configurations->get_hook_excluded());
        $this->assertEquals($expected['exclusions'], $configurations->get_exclusions());
        $this->assertEquals($expected['prefixes'], $configurations->get_prefixes());
    }
}
