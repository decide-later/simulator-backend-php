<?php

namespace app\engine;

class Transition
{
    private $name;
    private $target;
    private $title;
    private $callback;

    public function __construct(string $name, string $title, $target)
    {
        $this->name = $name;
        $this->title = $title;

        if (is_string($target)) {
            $this->target  = $target;
        } elseif ($target instanceof \Closure) {
            $this->callback = $target;
        } else {
            throw new \InvalidArgumentException('Target should be either new state name or callable.');
        }
    }

    public function getTarget(): string
    {
        return $this->target;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCallback(): ?callable
    {
        return $this->callback;
    }
}
