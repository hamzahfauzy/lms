<?php

use yii\db\Migration;

/**
 * Class m200413_165314_create_table_categories
 */
class m200413_165314_create_table_categories extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('categories', [
            'id'    => $this->primaryKey(),
            'name'  => $this->string(),
            'description'  => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200413_165314_create_table_categories cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200413_165314_create_table_categories cannot be reverted.\n";

        return false;
    }
    */
}
