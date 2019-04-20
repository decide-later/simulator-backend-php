<?php


namespace app\engine;


interface StateSource
{
    public function getState(string $name): State;
}
