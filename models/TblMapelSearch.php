<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TblMapel;

/**
 * PostSearch represents the model behind the search form of `app\models\Post`.
 */
class TblMapelSearch extends TblMapel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mapel_id','guru_admin_id'], 'integer'],
            [['mapel_nama'], 'safe'],
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
        $query = TblMapel::find();

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
            'mapel_id' => $this->mapel_id,
            'guru_admin_id' => $this->guru_admin_id,
        ]);

        $query->andFilterWhere(['like', 'mapel_nama', $this->mapel_nama]);

        return $dataProvider;
    }

}
