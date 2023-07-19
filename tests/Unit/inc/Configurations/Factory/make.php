<?php

namespace WPLaunchpad\HookExtractor\Tests\Unit\inc\Configurations\Factory;

use WPLaunchpad\HookExtractor\Configurations\Factory;


use WPLaunchpad\HookExtractor\Tests\Unit\TestCase;

/**
 * @covers \WPLaunchpad\HookExtractor\Configurations\Factory::make
 */
class Test_make extends TestCase {

    /**
     * @var Factory
     */
    protected $factory;

    public function set_up() {
        parent::set_up();

        $this->factory = new Factory();
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldReturnAsExpected( $config, $expected )
    {
        $configurations = $this->factory->make($config['data']);

        $this->assertEquals($expected['folders'], $configurations->get_folders());
        $this->assertEquals($expected['hook_excluded'], $configurations->get_hook_excluded());
        $this->assertEquals($expected['exclusions'], $configurations->get_exclusions());
        $this->assertEquals($expected['prefixes'], $configurations->get_prefixes());
    }
}
