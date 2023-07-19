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
     * @var FilesystemInterface
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
     * @param FilesystemInterface $filesystem
     * @param FactoryInterface $factory
     * @param ObjectValueFactoryInterface $object_value_factory
     * @param Folder $project_folder
     * @param Folder $app_folder
     */
    public function __construct(FilesystemInterface $filesystem, FactoryInterface $factory, ObjectValueFactoryInterface $object_value_factory, Folder $project_folder, Folder $app_folder)
    {
        $this->filesystem = $filesystem;
        $this->factory = $factory;
        $this->object_value_factory = $object_value_factory;
        $this->project_folder = $project_folder;
        $this->app_folder = $app_folder;
    }

    public function load(Path $path): Configuration {

        $configuration_paths = [
          $this->object_value_factory->create_path($this->project_folder->get_value() . DIRECTORY_SEPARATOR . 'hook-extractor.yml')
        ];

        array_unshift($configuration_paths, $path);

        foreach ($configuration_paths as $configuration_path) {
            if( ! $this->filesystem->exists($configuration_path) ) {
                continue;
            }
            $content = $this->filesystem->get_content($configuration_path);
            $yaml = yaml_parse($content);
            return $this->factory->make($yaml);
        }
        throw new ConfigurationException();
    }
}