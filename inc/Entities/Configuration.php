<?php

namespace WPLaunchpad\HookExtractor\Entities;

use WPLaunchpad\HookExtractor\ObjectValues\Content;
use WPLaunchpad\HookExtractor\ObjectValues\Folder;
use WPLaunchpad\HookExtractor\ObjectValues\Prefix;

class Configuration
{
    /**
     * @var Folder[]
     */
    protected $folders = [];

    /**
     * @var Content[]
     */
    protected $exclusions = [];

    /**
     * @var Prefix[]
     */
    protected $prefixes = [];

    /**
     * @var Prefix[]
     */
    protected $hook_excluded = [];

    /**
     * @return Folder[]
     */
    public function get_folders(): array
    {
        return $this->folders;
    }

    /**
     * @param Folder[] $folders
     */
    public function set_folders(array $folders): void
    {
        $this->folders = $folders;
    }

    /**
     * @return Content[]
     */
    public function get_exclusions(): array
    {
        return $this->exclusions;
    }

    /**
     * @param Content[] $exclusions
     */
    public function set_exclusions(array $exclusions): void
    {
        $this->exclusions = $exclusions;
    }

    /**
     * @return Prefix[]
     */
    public function get_prefixes(): array
    {
        return $this->prefixes;
    }

    /**
     * @param Prefix[] $prefixes
     */
    public function set_prefixes(array $prefixes): void
    {
        $this->prefixes = $prefixes;
    }

    /**
     * @return Prefix[]
     */
    public function get_hook_excluded(): array
    {
        return $this->hook_excluded;
    }

    /**
     * @param Prefix[] $hook_excluded
     */
    public function set_hook_excluded(array $hook_excluded): void
    {
        $this->hook_excluded = $hook_excluded;
    }
}