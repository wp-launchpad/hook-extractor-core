<?php

namespace WPLaunchpad\HookExtractor\Tests\Unit\inc\ObjectValues\Prefix;

use WPLaunchpad\HookExtractor\ObjectValues\Prefix;
use WPLaunchpad\HookExtractor\ObjectValues\InvalidValue;
use WPLaunchpad\HookExtractor\ObjectValues\ObjectValueTrait;


use WPLaunchpad\HookExtractor\Tests\Unit\TestCase;

/**
 * @covers \WPLaunchpad\HookExtractor\ObjectValues\Prefix::set_value
 */
class Test_setValue extends TestCase {

    /**
     * @var Prefix
     */
    protected $prefix;

    /**
     * @var string
     */
    protected $value;

    public function set_up() {
        parent::set_up();
        $this->value = '';

        $this->prefix = new Prefix($this->value);
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldDoAsExpected( $config, $expected )
    {
        if($expected['exception']) {
            $this->expectException(InvalidValue::class);
        }
        $this->prefix->set_value($config['value']);
        $this->assertSame($expected['value'], $this->prefix->get_value());
    }
}
