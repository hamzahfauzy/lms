<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tugas".
 *
 * @property int $id
 * @property int $jadwal_id
 * @property int $materi_id
 * @property int $soal_id
 *
 * @property TblJadwal $jadwal
 * @property Post $materi
 * @property Post $soal
 */
class Tugas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tugas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jadwal_id', 'materi_id', 'soal_id'], 'required'],
            [['jadwal_id', 'materi_id', 'soal_id'], 'integer'],
            [['jadwal_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblJadwal::className(), 'targetAttribute' => ['jadwal_id' => 'jadwal_id']],
            [['materi_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['materi_id' => 'id']],
            [['soal_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['soal_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jadwal_id' => 'Jadwal ID',
            'materi_id' => 'Materi ID',
            'soal_id' => 'Soal ID',
        ];
    }

    /**
     * Gets query for [[Jadwal]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJadwal()
    {
        return $this->hasOne(TblJadwal::className(), ['jadwal_id' => 'jadwal_id']);
    }

    /**
     * Gets query for [[Materi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMateri()
    {
        return $this->hasOne(Post::className(), ['id' => 'materi_id']);
    }

    /**
     * Gets query for [[Soal]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSoal()
    {
        return $this->hasOne(Post::className(), ['id' => 'soal_id']);
    }
}
