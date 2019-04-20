<?php


namespace app\engine;


class FailState extends State
{
    private const STATE = 'fail';

    public function getType(): string
    {
        return self::STATE;
    }
}
