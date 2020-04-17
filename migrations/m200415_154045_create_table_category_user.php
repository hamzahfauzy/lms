<?php

use yii\db\Migration;

/**
 * Class m200415_154045_create_table_category_user
 */
class m200415_154045_create_table_category_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('category_user', [
            'id'    => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
			'user_id'     => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-category_user-category_id',
            'category_user',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );
		
		$this->addForeignKey(
            'fk-category_user-user_id',
            'category_user',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200415_154045_create_table_category_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200415_154045_create_table_category_user cannot be reverted.\n";

        return false;
    }
    */
}
