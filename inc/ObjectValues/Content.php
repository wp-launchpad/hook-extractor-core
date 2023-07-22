<?php

namespace WPLaunchpad\HookExtractor\ObjectValues;

interface Content
{
    /**
     * Get the value.
     *
     * @return string
     */
    public function get_value(): string;
}