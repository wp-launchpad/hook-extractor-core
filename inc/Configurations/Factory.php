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

        $configuration->set_folders($this->fetch_includes($data));

        $configuration->set_exclusions($this->fetch_excludes($data));

        if( ! key_exists('hooks', $data)) {
            return $configuration;
        }

        $configuration->set_prefixes($this->fetch_prefix($data));

        $excludeds = [];
        foreach ($data['hooks']['excluded'] as $excluded) {
            $excludeds []= $this->object_value_factory->create_prefix($excluded);
        }
        $configuration->set_hook_excluded($excludeds);

        return $configuration;
    }

    protected function fetch_includes(array $data): array {
        if(! key_exists('includes', $data)) {
            return [];
        }

        $folders = [];
        foreach ($data['includes'] as $include) {
            $folders [] = $this->object_value_factory->create_folder($include);
        }

        return $folders;
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

    protected function fetch_prefix(array $data): array {
        if(! key_exists('hooks', $data) || ! key_exists('prefix', $data['hooks'])) {
            return [];
        }

        $prefixes = [];
        foreach ($data['hooks']['prefix'] as $prefix) {
            $prefixes [] = $this->object_value_factory->create_prefix($prefix);
        }

        return $prefixes;
    }
}