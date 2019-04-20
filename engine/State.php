<?php


namespace app\engine;


abstract class State
{
    private $name;
    private $content;

    public function __construct($name, $content)
    {
        $this->name = $name;
        $this->content = $content;
    }

    public function getName(): string
    {
        return $this->name;
    }

    abstract public function getType(): string;

    public function getContent(): string
    {
        return $this->content;
    }
}