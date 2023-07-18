<?php

namespace WPLaunchpad\HookExtractor\ObjectValues;

interface ObjectValueFactoryInterface
{
    public function create_path(string $path): Path;

    public function create_folder(string $path): Folder;

    public function create_prefix(string $prefix): Prefix;
}