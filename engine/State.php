<?php

namespace app\engine;

class State
{
    public const START = 'start';

    private $transitions = [];

    private $name;
    private $content;

    private function __construct()
    {
    }

    public static function content(string $content)
    {
        $new = new State();
        $new->content = $content;
        return $new;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function transition(string $name, string $title, $target): self
    {
        $transition = new Transition($name, $title, $target);
        $this->transitions[$name] = $transition;
        return $this;
    }

    public function getTransitions(): array
    {
        return $this->transitions;
    }

    public function getTransition(string $name): Transition
    {
        if (!isset($this->transitions[$name])) {
            $stateName = $this->getName();
            throw new NoTransition("There is no transition \"$name\" in state \"$stateName\"");
        }

        return $this->transitions[$name];
    }
}