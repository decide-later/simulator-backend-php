<?php


namespace app\engine;

class Html
{
    private $base;
    public function __construct(string $base)
    {
        $this->base = $base;
    }

    public function get(string $name): string
    {
        $path = $this->base . '/' . $name . '.html';
        if (!file_exists($path)) {
            throw new \RuntimeException("There is no resource at \"$path\"");
        }

        return file_get_contents($path);
    }
}
