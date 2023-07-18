<?php

namespace WPLaunchpad\HookExtractor\Tests\Unit\inc\ObjectValues\Path;

use Mockery;
use WPLaunchpad\HookExtractor\ObjectValues\Folder;
use WPLaunchpad\HookExtractor\ObjectValues\InvalidValue;
use WPLaunchpad\HookExtractor\ObjectValues\ObjectValueTrait;


use WPLaunchpad\HookExtractor\ObjectValues\Path;
use WPLaunchpad\HookExtractor\Tests\Unit\TestCase;

/**
 * @covers \WPLaunchpad\HookExtractor\ObjectValues\Path::set_value
 */
class Test_setValue extends TestCase {

    /**
     * @var Path
     */
    protected $folder;

    /**
     * @var string
     */
    protected $value;

    public function set_up() {
        parent::set_up();
        $this->value = '';

        $this->folder = new Path($this->value);
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
