<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_mapel".
 *
 * @property int $mapel_id
 * @property string|null $mapel_nama
 * @property string|null $guru_admin_id
 *
 * @property MapelPost[] $mapelPosts
 */
class TblMapel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_mapel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mapel_id'], 'required'],
            [['mapel_id'], 'integer'],
            [['mapel_nama', 'guru_admin_id'], 'string', 'max' => 45],
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
            'mapel_nama' => 'Mapel Nama',
            'guru_admin_id' => 'Guru Admin ID',
        ];
    }

    /**
     * Gets query for [[MapelPosts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMapelPosts()
    {
        return $this->hasMany(MapelPost::className(), ['mapel_id' => 'mapel_id']);
    }

    public function getEl()
    {
        return $this->hasOne(TblElMapel::className(),['mapel_id'=>'mapel_id']);
    }
}
