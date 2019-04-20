<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "savepoint".
 *
 * @property int $user_id
 * @property string $script
 * @property string $state
 */
class Savepoint extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'savepoint';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'script', 'state'], 'required'],
            [['user_id'], 'integer'],
            [['script', 'state'], 'string', 'max' => 255],
            [['user_id', 'script'], 'unique', 'targetAttribute' => ['user_id', 'script']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'script' => 'Script',
            'state' => 'State',
        ];
    }
}
