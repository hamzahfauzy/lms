<?php

use yii\db\Migration;

/**
 * Class m200413_170415_create_table_category_post
 */
class m200413_170415_create_table_category_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('category_post', [
            'id'    => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
			'post_id'     => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200413_170415_create_table_category_post cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200413_170415_create_table_category_post cannot be reverted.\n";

        return false;
    }
    */
}
