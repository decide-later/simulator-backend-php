<?php


namespace app\engine;


class Script implements StateSource
{
    private $name;
    private $states;

    public function __construct(string $name, array $states)
    {
        $this->name = $name;
        $this->states = $states;
    }

    public function getState(string $name): State
    {
        if (!isset($this->states[$name])) {
            throw new NoState("State \"$name\" not found.");
        }

        $state = $this->states[$name];
        $state->name($name);
        return $state;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
