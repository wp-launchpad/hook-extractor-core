<?php

namespace WPLaunchpad\HookExtractor\Filesystem;

use WPLaunchpad\HookExtractor\ObjectValues\Content;
use WPLaunchpad\HookExtractor\ObjectValues\Folder;
use WPLaunchpad\HookExtractor\ObjectValues\Path;

interface FilesystemInterface
{
    /**
     * Check if the content exists.
     *
     * @param Content $path Content to check.
     *
     * @return bool
     */
    public function exists(Content $path): bool;

    /**
     * Get the path content.
     *
     * @param Path $path Path to get content from.
     * @return string
     */
    public function get_content(Path $path): string;

    /**
     * List content from folder.
     *
     * @param Folder $folder Folder to list.
     * @param bool $recursive Is the listing recursive.
     * @return array
     */
    public function list(Folder $folder, bool $recursive = false): array;
}