<?php

use yii\db\Migration;

/**
 * Class m200414_162052_create_table_roles
 */
class m200414_152052_create_table_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('roles', [
            'id'    => $this->primaryKey(),
            'name'  => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200414_162052_create_table_roles cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200414_162052_create_table_roles cannot be reverted.\n";

        return false;
    }
    */
}
