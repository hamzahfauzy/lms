<?php

use yii\db\Migration;

/**
 * Class m200413_170238_create_table_post_meta
 */
class m200413_170238_create_table_post_meta extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('post_meta', [
            'id'    => $this->primaryKey(),
            'post_id'    => $this->integer()->notNull(),
            'meta_key'   => $this->string(),
			'meta_value' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200413_170238_create_table_post_meta cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200413_170238_create_table_post_meta cannot be reverted.\n";

        return false;
    }
    */
}
