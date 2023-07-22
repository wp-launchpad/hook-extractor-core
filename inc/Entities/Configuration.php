<?php

namespace WPLaunchpad\HookExtractor\Entities;

use WPLaunchpad\HookExtractor\ObjectValues\Content;
use WPLaunchpad\HookExtractor\ObjectValues\Folder;
use WPLaunchpad\HookExtractor\ObjectValues\Prefix;

class Configuration
{
    /**
     * Folders to scan.
     *
     * @var Folder[]
     */
    protected $folders = [];

    /**
     * Excluded contents.
     *
     * @var Content[]
     */
    protected $exclusions = [];

    /**
     * Prefixes to scan.
     *
     * @var Prefix[]
     */
    protected $prefixes = [];

    /**
     * Prefixes to exclude.
     *
     * @var Prefix[]
     */
    protected $hook_excluded = [];

    /**
     * Get folders to scan.
     *
     * @return Folder[]
     */
    public function get_folders(): array
    {
        return $this->folders;
    }

    /**
     * Set folders to scan.
     *
     * @param Folder[] $folders
     */
    public function set_folders(array $folders): void
    {
        $this->folders = $folders;
    }

    /**
     * Get folders to exclude.
     *
     * @return Content[]
     */
    public function get_exclusions(): array
    {
        return $this->exclusions;
    }

    /**
     * Set folders to exclude.
     *
     * @param Content[] $exclusions
     */
    public function set_exclusions(array $exclusions): void
    {
        $this->exclusions = $exclusions;
    }

    /**
     * Get prefix to scan.
     *
     * @return Prefix[]
     */
    public function get_prefixes(): array
    {
        return $this->prefixes;
    }

    /**
     * Set prefix to scan.
     *
     * @param Prefix[] $prefixes
     */
    public function set_prefixes(array $prefixes): void
    {
        $this->prefixes = $prefixes;
    }

    /**
     * Get excluded prefixes.
     *
     * @return Prefix[]
     */
    public function get_hook_excluded(): array
    {
        return $this->hook_excluded;
    }

    /**
     * Set excluded prefixes.
     *
     * @param Prefix[] $hook_excluded
     */
    public function set_hook_excluded(array $hook_excluded): void
    {
        $this->hook_excluded = $hook_excluded;
    }
}