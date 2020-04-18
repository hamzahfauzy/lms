<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property int $post_author_id
 * @property string|null $post_title
 * @property string|null $post_content
 * @property string|null $post_excerpt
 * @property int|null $post_status
 * @property string|null $post_as
 * @property int $post_parent_id
 * @property string|null $post_type
 * @property string|null $post_mime_type
 * @property int|null $comment_status
 * @property int|null $comment_count
 * @property int $post_date
 * @property int $post_modified
 *
 * @property CategoryPost[] $categoryPosts
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_author_id', 'post_date', 'post_modified'], 'required'],
            [['post_author_id', 'post_status', 'post_parent_id', 'comment_status', 'comment_count', 'post_date', 'post_modified'], 'integer'],
            [['post_content', 'post_excerpt'], 'string'],
            [['post_title', 'post_as', 'post_type', 'post_mime_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_author_id' => 'Author ID',
            'post_title' => 'Title',
            'post_content' => 'Content',
            'post_excerpt' => 'Excerpt',
            'post_status' => 'Status',
            'post_as' => 'Post As',
            'post_parent_id' => 'Post Parent ID',
            'post_type' => 'Post Type',
            'post_mime_type' => 'Post Mime Type',
            'comment_status' => 'Comment Status',
            'comment_count' => 'Comment Count',
            'post_date' => 'Post Date',
            'post_modified' => 'Post Modified',
        ];
    }

    /**
     * Gets query for [[CategoryPosts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryPosts()
    {
        return $this->hasMany(CategoryPost::className(), ['post_id' => 'id']);
    }

    public function getSubPosts()
    {
        return $this->hasMany(Post::className(), ['post_parent_id' => 'id']);
    }

    public function getMapelPost()
    {
        return $this->hasOne(MapelPost::className(), ['post_id' => 'id']);
    }

    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['guru_id' => 'post_author_id']);
    }

    public function getParent()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_parent_id']);
    }

    public function meta($key = false)
    {
        if(!$key)
            return PostMeta::find()->where(['post_id'=>$this->id,'meta_key'=>$key])->one()->meta_value;
        return PostMeta::find()->where(['post_id'=>$this->id])->all();
        
    }
}
