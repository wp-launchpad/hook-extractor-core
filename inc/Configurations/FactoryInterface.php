<?php

namespace WPLaunchpad\HookExtractor\Configurations;

use WPLaunchpad\HookExtractor\Entities\Configuration;

interface FactoryInterface
{
    /**
     * Make configuration.
     *
     * @param array $data Data from configuration.
     * @return Configuration
     */
    public function make(array $data): Configuration;
}