<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%repositories}}`.
 */
class m241220_093213_create_repositories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%repositories}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'url' => $this->string(500)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-repositories-user_id',
            '{{%repositories}}',
            'user_id',
            '{{%github_users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-repositories-user_id', '{{%repositories}}');
        $this->dropTable('{{%repositories}}');
    }
}
