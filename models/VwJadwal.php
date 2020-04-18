<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vw_jadwal".
 *
 * @property int $jadwal_id
 * @property string|null $tahun_akademik
 * @property string|null $kelas
 * @property string|null $hari
 * @property string|null $jam
 * @property string|null $mapel_id
 * @property string|null $mapel_nama
 * @property string|null $guru_id
 * @property string|null $guru_nama
 */
class VwJadwal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vw_jadwal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jadwal_id'], 'required'],
            [['jadwal_id'], 'integer'],
            [['tahun_akademik', 'kelas', 'hari', 'jam', 'mapel_id', 'mapel_nama', 'guru_id', 'guru_nama'], 'string', 'max' => 45],
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
            'mapel_nama' => 'Mapel Nama',
            'guru_id' => 'Guru ID',
            'guru_nama' => 'Guru Nama',
        ];
    }
}
