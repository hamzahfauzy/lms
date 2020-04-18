<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vw_kelas".
 *
 * @property string $tahun_akademik
 * @property string $kelas
 * @property string $siswa_id
 * @property string|null $siswa_nama
 * @property string|null $hari
 * @property string|null $jam
 * @property string|null $mapel_id
 * @property string|null $mapel_nama
 * @property string|null $guru_id
 * @property string|null $guru_nama
 */
class VwKelas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vw_kelas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun_akademik', 'kelas', 'siswa_id'], 'required'],
            [['tahun_akademik', 'kelas'], 'string', 'max' => 5],
            [['siswa_id'], 'string', 'max' => 10],
            [['siswa_nama', 'hari', 'jam', 'mapel_id', 'mapel_nama', 'guru_id', 'guru_nama'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tahun_akademik' => 'Tahun Akademik',
            'kelas' => 'Kelas',
            'siswa_id' => 'Siswa ID',
            'siswa_nama' => 'Siswa Nama',
            'hari' => 'Hari',
            'jam' => 'Jam',
            'mapel_id' => 'Mapel ID',
            'mapel_nama' => 'Mapel Nama',
            'guru_id' => 'Guru ID',
            'guru_nama' => 'Guru Nama',
        ];
    }
}
