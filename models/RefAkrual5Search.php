<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefAkrual5;

/**
 * RefAkrual5Search represents the model behind the search form of `app\models\RefAkrual5`.
 */
class RefAkrual5Search extends RefAkrual5
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3', 'kd_akrual_4', 'kd_akrual_5'], 'integer'],
            [['nm_akrual_5', 'peraturan'], 'safe'],
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
        $query = RefAkrual5::find();

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
            'kd_akrual_1' => $this->kd_akrual_1,
            'kd_akrual_2' => $this->kd_akrual_2,
            'kd_akrual_3' => $this->kd_akrual_3,
            'kd_akrual_4' => $this->kd_akrual_4,
            'kd_akrual_5' => $this->kd_akrual_5,
        ]);

        $query->andFilterWhere(['like', 'nm_akrual_5', $this->nm_akrual_5])
            ->andFilterWhere(['like', 'peraturan', $this->peraturan]);

        return $dataProvider;
    }
}
