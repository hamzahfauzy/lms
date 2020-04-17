<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Post;

/**
 * PostSearch represents the model behind the search form of `app\models\Post`.
 */
class PostSearch extends Post
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'post_author_id', 'post_status', 'post_parent_id', 'comment_status', 'comment_count', 'post_date', 'post_modified'], 'integer'],
            [['post_title', 'post_content', 'post_excerpt', 'post_as', 'post_type', 'post_mime_type'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Post::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'post_author_id' => $this->post_author_id,
            'post_status' => $this->post_status,
            'post_parent_id' => $this->post_parent_id,
            'comment_status' => $this->comment_status,
            'comment_count' => $this->comment_count,
            'post_date' => $this->post_date,
            'post_modified' => $this->post_modified,
        ]);

        $query->andFilterWhere(['like', 'post_title', $this->post_title])
            ->andFilterWhere(['like', 'post_content', $this->post_content])
            ->andFilterWhere(['like', 'post_excerpt', $this->post_excerpt])
            ->andFilterWhere(['like', 'post_as', $this->post_as])
            ->andFilterWhere(['like', 'post_type', $this->post_type])
            ->andFilterWhere(['like', 'post_mime_type', $this->post_mime_type]);

        return $dataProvider;
    }
}
