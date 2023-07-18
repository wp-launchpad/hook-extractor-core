<?php

namespace WPLaunchpad\HookExtractor\Configurations;

use WPLaunchpad\HookExtractor\Entities\Configuration;

class Factory implements FactoryInterface
{
    public function make(array $data): Configuration
    {
        return new Configuration($data);
    }
}