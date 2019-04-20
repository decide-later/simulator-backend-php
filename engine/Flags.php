<?php


namespace app\engine;


use app\models\Flag;

class Flags
{
    public static function read(string $name): ?string
    {
        /** @var Flag $flag */
        $flag = Flag::find()->where(['name' => $name, 'user_id' => 1, 'savepoint_id' => 1])->one();
        return $flag->value ?? null;
    }

    public static function write(string $name, string $value): void
    {
        /** @var Flag $flag */
        $flag = Flag::find()->where(['name' => $name, 'user_id' => 1, 'savepoint_id' => 1])->one();
        if (!$flag) {
            $flag = new Flag();
            $flag->name = $name;
            $flag->savepoint_id = 1;
            $flag->user_id = 1;
        }
        $flag->value = $value;
        if (!$flag->save()) {
            throw new \RuntimeException('Unble to save flag: ' . json_encode($flag->getErrors()));
        }
    }
}