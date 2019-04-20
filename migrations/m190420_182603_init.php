<?php

use yii\db\Migration;

/**
 * Class m190420_182603_init
 */
class m190420_182603_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('flag', [
            'savepoint_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'value' => $this->string()->notNull(),
            'PRIMARY KEY (user_id, name, value)'
        ]);

        $this->createTable('savepoint', [
            'user_id' => $this->integer()->notNull(),
            'script' => $this->string()->notNull(),
            'state' => $this->string()->notNull(),
            'PRIMARY KEY(user_id, script)'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('flag');
        $this->dropTable('savepoint');
    }
}
