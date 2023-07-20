<?php

namespace WPLaunchpad\HookExtractor\ObjectValues;

class Path implements Content
{
    use ObjectValueTrait;

    protected function check_validate_rule(string $value): bool
    {
        return (bool) preg_match('#^(/?[^:/ ]*)+/?$#', $value);
    }
}