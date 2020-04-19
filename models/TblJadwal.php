<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_jadwal".
 *
 * @property int $jadwal_id
 * @property string|null $tahun_akademik
 * @property string|null $kelas
 * @property string|null $hari
 * @property string|null $jam
 * @property string|null $mapel_id
 * @property string|null $guru_id
 *
 * @property Tuga[] $tugas
 */
class TblJadwal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_jadwal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jadwal_id'], 'required'],
            [['jadwal_id'], 'integer'],
            [['tahun_akademik', 'kelas', 'hari', 'jam', 'mapel_id', 'guru_id'], 'string', 'max' => 45],
            [['jadwal_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'jadwal_id' => 'Jadwal ID',
            'tahun_akademik' => 'Tahun Akademik',
            'kelas' => 'Kelas',
            'hari' => 'Hari',
            'jam' => 'Jam',
            'mapel_id' => 'Mapel ID',
            'guru_id' => 'Guru ID',
        ];
    }

    /**
     * Gets query for [[Tugas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTugas()
    {
        return $this->hasMany(Tuga::className(), ['jadwal_id' => 'jadwal_id']);
    }
}
