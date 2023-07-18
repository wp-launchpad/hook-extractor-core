<?php

namespace WPLaunchpad\HookExtractor\ObjectValues;

trait ObjectValueTrait
{
    /**
     * @var string
     */
    protected $value = '';

    /**
     * @param string $value
     */
    public function __construct(string $value = '')
    {
        if('' === $value) {
            return;
        }
        $this->set_value($value);
    }

    /**
     * @return string
     */
    public function get_value(): string
    {
        return $this->value;
    }

    public function set_value(string $value): void  {
        $this->validate($value);
        $this->value = $value;
    }

    /**
     * @param string $value
     * @return void
     * @throws InvalidValue Raise on invalid value.
     */
    protected function validate(string $value): void {
        if (! $this->check_validate_rule($value)) {
            throw new InvalidValue();
        }
    }

    abstract protected function check_validate_rule(string $value): bool;
}