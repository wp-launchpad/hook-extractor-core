<?php

namespace WPLaunchpad\HookExtractor\Configurations;

use WPLaunchpad\HookExtractor\Entities\Configuration;
use WPLaunchpad\HookExtractor\Filesystem\FilesystemInterface;
use WPLaunchpad\HookExtractor\ObjectValues\Folder;
use WPLaunchpad\HookExtractor\ObjectValues\ObjectValueFactoryInterface;
use WPLaunchpad\HookExtractor\ObjectValues\Path;

class Loader
{
    /**
     * Filesystem.
     *
     * @var FilesystemInterface
     */
    protected $filesystem;

    /**
     * Configuration factory.
     *
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * ObjectValue factory.
     *
     * @var ObjectValueFactoryInterface
     */
    protected $object_value_factory;

    /**
     * Project folder.
     *
     * @var Folder
     */
    protected $project_folder;

    /**
     * Application folder.
     *
     * @var Folder
     */
    protected $app_folder;

    /**
     * Instantiate loader.
     *
     * @param FilesystemInterface $filesystem Filesystem.
     * @param FactoryInterface $factory Configuration factory.
     * @param ObjectValueFactoryInterface $object_value_factory ObjectValue factory.
     * @param Folder $project_folder Project folder.
     * @param Folder $app_folder Application folder.
     */
    public function __construct(FilesystemInterface $filesystem, FactoryInterface $factory, ObjectValueFactoryInterface $object_value_factory, Folder $project_folder, Folder $app_folder)
    {
        $this->filesystem = $filesystem;
        $this->factory = $factory;
        $this->object_value_factory = $object_value_factory;
        $this->project_folder = $project_folder;
        $this->app_folder = $app_folder;
    }

    /**
     * Load configuration.
     *
     * @param Path $path Path from the configuration.
     *
     * @return Configuration
     * @throws ConfigurationException
     */
    public function load(Path $path): Configuration {

        $configuration_paths = [
          $this->object_value_factory->create_path($this->project_folder->get_value() . DIRECTORY_SEPARATOR . 'hook-extractor.yml'),
          $this->object_value_factory->create_path($this->app_folder->get_value() . DIRECTORY_SEPARATOR . 'configs/default.yml'),
        ];

        array_unshift($configuration_paths, $path);

        foreach ($configuration_paths as $configuration_path) {
            if( ! $this->filesystem->exists($configuration_path) ) {
                continue;
            }
            $content = $this->filesystem->get_content($configuration_path);
            if( ! $content ) {
                continue;
            }
            $yaml = yaml_parse($content);
            if(! is_array($yaml)) {
                continue;
            }
            return $this->factory->make($yaml);
        }
        throw new ConfigurationException();
    }
}