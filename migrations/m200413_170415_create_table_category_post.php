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
		$this->createTable('mapel_post', [
            'id'    => $this->primaryKey(),
            'mapel_id' => $this->integer()->notNull(),
			'post_id'     => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-mapel_post-mapel_id',
            'mapel_post',
            'mapel_id',
            'tbl_mapel',
            'mapel_id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-mapel_post-post_id',
            'mapel_post',
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
