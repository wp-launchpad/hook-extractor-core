<?php

namespace WPLaunchpad\HookExtractor\ObjectValues;

interface ObjectValueFactoryInterface
{
    /**
     * Create path.
     *
     * @param string $path Path.
     * @return Path
     */
    public function create_path(string $path): Path;

    /**
     * Create folder.
     *
     * @param string $path Path.
     * @return Folder
     */
    public function create_folder(string $path): Folder;

    /**
     * Create prefix.
     *
     * @param string $prefix Prefix.
     * @return Prefix
     */
    public function create_prefix(string $prefix): Prefix;
}