<?php

namespace WPLaunchpad\HookExtractor\Configurations;

use League\Flysystem\Filesystem;
use WPLaunchpad\HookExtractor\Entities\Configuration;
use WPLaunchpad\HookExtractor\ObjectValues\Folder;
use WPLaunchpad\HookExtractor\ObjectValues\ObjectValueFactoryInterface;
use WPLaunchpad\HookExtractor\ObjectValues\Path;

class Loader
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * @var ObjectValueFactoryInterface
     */
    protected $object_value_factory;

    /**
     * @var Folder
     */
    protected $project_folder;

    /**
     * @var Folder
     */
    protected $app_folder;

    /**
     * @param Filesystem $filesystem
     * @param FactoryInterface $factory
     * @param ObjectValueFactoryInterface $object_value_factory
     * @param Folder $project_folder
     * @param Folder $app_folder
     */
    public function __construct(Filesystem $filesystem, FactoryInterface $factory, ObjectValueFactoryInterface $object_value_factory, Folder $project_folder, Folder $app_folder)
    {
        $this->filesystem = $filesystem;
        $this->factory = $factory;
        $this->object_value_factory = $object_value_factory;
        $this->project_folder = $project_folder;
        $this->app_folder = $app_folder;
    }

    public function load(Path $path): Configuration {
        return null;
    }
}