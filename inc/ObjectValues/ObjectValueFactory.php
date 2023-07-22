<?php

namespace WPLaunchpad\HookExtractor\ObjectValues;

class ObjectValueFactory implements ObjectValueFactoryInterface
{
    /**
     * Create path.
     *
     * @param string $path Path.
     * @return Path
     */
    public function create_path(string $path): Path
    {
        return new Path($path);
    }

    /**
     * Create folder.
     *
     * @param string $path Path.
     * @return Folder
     */
    public function create_folder(string $path): Folder
    {
        return new Folder($path);
    }

    /**
     * Create prefix.
     *
     * @param string $prefix Prefix.
     * @return Prefix
     */
    public function create_prefix(string $prefix): Prefix
    {
        return new Prefix($prefix);
    }
}