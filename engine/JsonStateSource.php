<?php


namespace app\engine;


class JsonStateSource implements StateSource
{
    private $questName;

    public function __construct(string $questName)
    {
        $this->questName = $questName;
    }

    public function getState(string $name): State
    {
        $scriptFileName = \Yii::getAlias('@app/scripts') . '/' . $this->questName . '/' . $name . '.json';
        if (!file_exists($scriptFileName)) {
            throw  new NoStateInSource("No state \"$name\" found.");
        }

        $rawData = json_decode(file_get_contents($scriptFileName), true);
        
    }
}
