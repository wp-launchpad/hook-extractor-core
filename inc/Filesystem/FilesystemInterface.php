<?php

namespace WPLaunchpad\HookExtractor\Filesystem;

use WPLaunchpad\HookExtractor\ObjectValues\Content;
use WPLaunchpad\HookExtractor\ObjectValues\Folder;
use WPLaunchpad\HookExtractor\ObjectValues\Path;

interface FilesystemInterface
{
    public function exists(Content $path): bool;
    public function get_content(Path $path): string;

    public function list(Folder $folder, bool $recursive = false): array;
}