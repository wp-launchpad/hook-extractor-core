<?php

namespace WPLaunchpad\HookExtractor\Tests\Unit;

use ReflectionObject;

abstract class TestCase extends \WPMedia\PHPUnit\Unit\TestCase
{
    protected function setUp(): void {
        parent::setUp();

        if ( empty( $this->config ) ) {
            $this->loadTestDataConfig();
        }
    }

    public function configTestData() {
        if ( empty( $this->config ) ) {
            $this->loadTestDataConfig();
        }

        return isset( $this->config['test_data'] )
            ? $this->config['test_data']
            : $this->config;
    }

    protected function loadTestDataConfig() {
        $obj      = new ReflectionObject( $this );
        $filename = $obj->getFileName();

        $this->config = $this->getTestData( dirname( $filename ), basename( $filename, '.php' ) );
    }
}