<?php

namespace WPLaunchpad\HookExtractor\Tests\Unit\inc\ObjectValues\ObjectValueTrait;

use Mockery;
use WPLaunchpad\HookExtractor\ObjectValues\InvalidValue;
use WPLaunchpad\HookExtractor\ObjectValues\ObjectValueTrait;


use WPLaunchpad\HookExtractor\Tests\Unit\TestCase;

/**
 * @covers \WPLaunchpad\HookExtractor\ObjectValues\ObjectValueTrait::set_value
 */
class Test_setValue extends TestCase {

    /**
     * @var ObjectValueTrait
     */
    protected $objectvaluetrait;

    /**
     * @var string
     */
    protected $value;

    public function set_up() {
        parent::set_up();
        $this->value = '';

        $this->objectvaluetrait = Mockery::mock(ObjectValueTrait::class, [$this->value])->shouldAllowMockingProtectedMethods()->makePartial();
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldDoAsExpected( $config, $expected )
    {
        $this->objectvaluetrait->expects()->check_validate_rule($config['value'])->andReturn($config['is_valid']);
        if($expected['exception']) {
            $this->expectException(InvalidValue::class);
        }
        $this->objectvaluetrait->set_value($config['value']);
        $this->assertSame($expected['value'], $this->objectvaluetrait->get_value());
    }
}
