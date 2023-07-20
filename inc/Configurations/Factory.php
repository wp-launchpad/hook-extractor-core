<?php

namespace WPLaunchpad\HookExtractor\Configurations;

use WPLaunchpad\HookExtractor\Entities\Configuration;
use WPLaunchpad\HookExtractor\ObjectValues\ObjectValueFactoryInterface;

class Factory implements FactoryInterface
{
    /**
     * @var ObjectValueFactoryInterface
     */
    protected $object_value_factory;

    /**
     * @param ObjectValueFactoryInterface $object_value_factory
     */
    public function __construct(ObjectValueFactoryInterface $object_value_factory)
    {
        $this->object_value_factory = $object_value_factory;
    }

    public function make(array $data): Configuration
    {
        $configuration = new Configuration();
        $folders = [];
        foreach ($data['includes'] as $include) {
            $folders [] = $this->object_value_factory->create_folder($include);
        }
        $configuration->set_folders($folders);

        $configuration->set_exclusions($this->fetch_excludes($data));

        $prefixes = [];
        foreach ($data['hooks']['prefix'] as $prefix) {
            $prefixes [] = $this->object_value_factory->create_prefix($prefix);
        }
        $configuration->set_prefixes($prefixes);

        $excludeds = [];
        foreach ($data['hooks']['excluded'] as $excluded) {
            $excludeds []= $this->object_value_factory->create_prefix($excluded);
        }
        $configuration->set_hook_excluded($excludeds);

        return $configuration;
    }

    protected function fetch_excludes(array $data): array {
        if(! key_exists('excludes', $data)) {
            return [];
        }

        $excludes = [];
        foreach ($data['excludes'] as $exclude) {
            $excludes []= $this->object_value_factory->create_path($exclude);
        }

        return $excludes;
    }
}