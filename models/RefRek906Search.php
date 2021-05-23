<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefRek906;

/**
 * RefRek906Search represents the model behind the search form of `app\models\RefRek906`.
 */
class RefRek906Search extends RefRek906
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_rek90_1', 'kd_rek90_2', 'kd_rek90_3', 'kd_rek90_4', 'kd_rek90_5', 'kd_rek90_6'], 'integer'],
            [['nm_rek90_6', 'peraturan'], 'safe'],
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
        $query = RefRek906::find();

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
            'kd_rek90_1' => $this->kd_rek90_1,
            'kd_rek90_2' => $this->kd_rek90_2,
            'kd_rek90_3' => $this->kd_rek90_3,
            'kd_rek90_4' => $this->kd_rek90_4,
            'kd_rek90_5' => $this->kd_rek90_5,
            'kd_rek90_6' => $this->kd_rek90_6,
        ]);

        $query->andFilterWhere(['like', 'nm_rek90_6', $this->nm_rek90_6])
            ->andFilterWhere(['like', 'peraturan', $this->peraturan]);

        return $dataProvider;
    }
}
