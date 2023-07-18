<?php

namespace WPLaunchpad\HookExtractor\ObjectValues;

class ObjectValueFactory implements ObjectValueFactoryInterface
{
    public function create_path(string $path): Path
    {
        return new Path($path);
    }

    public function create_folder(string $path): Folder
    {
        return new Folder($path);
    }

    public function create_prefix(string $prefix): Prefix
    {
        return new Prefix($prefix);
    }
}