<?php

namespace WPLaunchpad\HookExtractor\Tests\Unit\inc\ObjectValues\Folder;

use Mockery;
use WPLaunchpad\HookExtractor\ObjectValues\Folder;
use WPLaunchpad\HookExtractor\ObjectValues\InvalidValue;
use WPLaunchpad\HookExtractor\ObjectValues\ObjectValueTrait;


use WPLaunchpad\HookExtractor\Tests\Unit\TestCase;

/**
 * @covers \WPLaunchpad\HookExtractor\ObjectValues\Folder::set_value
 */
class Test_setValue extends TestCase {

    /**
     * @var ObjectValueTrait
     */
    protected $folder;

    /**
     * @var string
     */
    protected $value;

    public function set_up() {
        parent::set_up();
        $this->value = '';

        $this->folder = new Folder($this->value);
    }

    /**
     * @dataProvider configTestData
     */
    public function testShouldDoAsExpected( $config, $expected )
    {
        if($expected['exception']) {
            $this->expectException(InvalidValue::class);
        }
        $this->folder->set_value($config['value']);
        $this->assertSame($expected['value'], $this->folder->get_value());
    }
}
