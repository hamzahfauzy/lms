<?php

use yii\db\Migration;

/**
 * Class m200413_165618_create_table_posts
 */
class m200413_165618_create_table_posts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('posts', [
            'id'    => $this->primaryKey(),
            'post_author_id' => $this->integer()->notNull(),
            'post_title'  	 => $this->string(),
			'post_content'   => $this->text(),
			'post_excerpt'   => $this->text(),
			'post_status'    => $this->integer()->defaultValue(1),
			'post_as'  	     => $this->string(),
			'post_parent_id' => $this->integer()->defaultValue(NULL),
			'post_type'  	 => $this->string(),
			'post_mime_type' => $this->string(),
			'comment_status' => $this->integer()->defaultValue(0),
			'comment_count'  => $this->integer()->defaultValue(0),
			'post_date'		 => $this->integer()->notNull(),
			'post_modified'  => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200413_165618_create_table_posts cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200413_165618_create_table_posts cannot be reverted.\n";

        return false;
    }
    */
}
