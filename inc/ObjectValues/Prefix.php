<?php

namespace WPLaunchpad\HookExtractor\ObjectValues;

class Prefix implements Content
{
    use ObjectValueTrait;

    /**
     * Validate the value against the rule.
     *
     * @param string $value Value to check.
     *
     * @return bool
     */
    protected function check_validate_rule(string $value): bool
    {
        return (bool) preg_match('/^([a-zA-Z]_?)+$/', $value);
    }
}