<?php

namespace WPLaunchpad\HookExtractor\Configurations;

use WPLaunchpad\HookExtractor\Entities\Configuration;

interface FactoryInterface
{
    public function make(array $data): Configuration;
}