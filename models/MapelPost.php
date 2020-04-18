<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mapel_post".
 *
 * @property int $id
 * @property int $mapel_id
 * @property int $post_id
 *
 * @property TblMapel $mapel
 * @property Post $post
 */
class MapelPost extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mapel_post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mapel_id', 'post_id'], 'required'],
            [['mapel_id', 'post_id'], 'integer'],
            [['mapel_id'], 'exist', 'skipOnError' => true, 'targetClass' => TblMapel::className(), 'targetAttribute' => ['mapel_id' => 'mapel_id']],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mapel_id' => 'Mapel ID',
            'post_id' => 'Post ID',
        ];
    }

    /**
     * Gets query for [[Mapel]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMapel()
    {
        return $this->hasOne(TblMapel::className(), ['mapel_id' => 'mapel_id']);
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }
}
