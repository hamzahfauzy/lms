<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_el_mapel".
 *
 * @property int $mapel_id
 * @property string|null $deskripsi
 * @property string|null $capaian_pembelajaran
 */
class TblElMapel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_el_mapel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mapel_id'], 'required'],
            [['mapel_id'], 'integer'],
            [['deskripsi', 'capaian_pembelajaran'], 'string'],
            [['mapel_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mapel_id' => 'Mapel ID',
            'deskripsi' => 'Deskripsi',
            'capaian_pembelajaran' => 'Capaian Pembelajaran',
        ];
    }
}
