<?php

namespace WPLaunchpad\HookExtractor\Filesystem;

use WPLaunchpad\HookExtractor\ObjectValues\Folder;
use WPLaunchpad\HookExtractor\ObjectValues\Path;

interface FilesystemInterface
{
    public function exists(Path $path): bool;
    public function get_content(Path $path): string;

    public function list(Folder $folder): array;
}