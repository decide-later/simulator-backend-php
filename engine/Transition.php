<?php

namespace app\engine;

class Transition
{
    private $name;
    private $title;
    private $flags;

    public function __construct(string $name, string $title, array $flags)
    {
        $this->name  = $name;
        $this->title = $title;
        $this->flags = $flags;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getFlags(): array
    {
        return $this->flags;
    }
}
