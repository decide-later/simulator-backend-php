<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "flag".
 *
 * @property int $savepoint_id
 * @property int $user_id
 * @property string $name
 * @property string $value
 */
class Flag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'flag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['savepoint_id', 'user_id', 'name', 'value'], 'required'],
            [['savepoint_id', 'user_id'], 'integer'],
            [['name', 'value'], 'string', 'max' => 255],
            [['user_id', 'name', 'value'], 'unique', 'targetAttribute' => ['user_id', 'name', 'value']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'savepoint_id' => 'Savepoint ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'value' => 'Value',
        ];
    }
}
