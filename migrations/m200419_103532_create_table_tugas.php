<?php

use yii\db\Migration;

/**
 * Class m200419_103532_create_table_tugas
 */
class m200419_103532_create_table_tugas extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tugas', [
            'id'    => $this->primaryKey(),
            'jadwal_id' => $this->integer()->notNull(),
            'materi_id' => $this->integer()->notNull(),
            'soal_id'   => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-tugas-jadwal_id',
            'tugas',
            'jadwal_id',
            'tbl_jadwal',
            'jadwal_id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-tugas-materi_id',
            'tugas',
            'materi_id',
            'posts',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-tugas-soal_id',
            'tugas',
            'soal_id',
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
        echo "m200419_103532_create_table_tugas cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200419_103532_create_table_tugas cannot be reverted.\n";

        return false;
    }
    */
}
