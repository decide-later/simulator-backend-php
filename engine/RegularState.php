<?php


namespace app\engine;


class RegularState extends State
{
    private const TYPE = 'regular';

    private $transitions;

    /**
     * RegularState constructor.
     * @param array $transitions
     */
    public function __construct(string $name, string $content, array $transitions)
    {
        $this->transitions = $transitions;
        parent::__construct($name, $content, $transitions);
    }


    public function getType(): string
    {
        return self::TYPE;
    }


}
