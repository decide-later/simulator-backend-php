<?php


namespace app\engine;


class FinishState extends State
{
    private const STATE = 'finish';

    public function getType(): string
    {
        return self::STATE;
    }
}
