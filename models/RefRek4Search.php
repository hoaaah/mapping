<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefRek4;

/**
 * RefRek4Search represents the model behind the search form about `app\models\RefRek4`.
 */
class RefRek4Search extends RefRek4
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'kd_ubah', 'id_lama'], 'integer'],
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'nm_rek_4'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = RefRek4::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'kd_ubah' => $this->kd_ubah,
            'id_lama' => $this->id_lama,
        ]);

        $query->andFilterWhere(['like', 'kd_rek_1', $this->kd_rek_1])
            ->andFilterWhere(['like', 'kd_rek_2', $this->kd_rek_2])
            ->andFilterWhere(['like', 'kd_rek_3', $this->kd_rek_3])
            ->andFilterWhere(['like', 'kd_rek_4', $this->kd_rek_4])
            ->andFilterWhere(['like', 'nm_rek_4', $this->nm_rek_4]);

        return $dataProvider;
    }
}
