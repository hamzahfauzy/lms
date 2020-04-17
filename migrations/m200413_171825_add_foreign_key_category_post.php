<?php

use yii\db\Migration;

/**
 * Class m200413_171825_add_foreign_key_category_post
 */
class m200413_171825_add_foreign_key_category_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->addForeignKey(
            'fk-category_post-category_id',
            'category_post',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );
		
		$this->addForeignKey(
            'fk-category_post-post_id',
            'category_post',
            'post_id',
            'posts',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200413_171825_add_foreign_key_category_post cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200413_171825_add_foreign_key_category_post cannot be reverted.\n";

        return false;
    }
    */
}
