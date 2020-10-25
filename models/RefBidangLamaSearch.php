<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefBidangLama;

/**
 * RefBidangLamaSearch represents the model behind the search form about `app\models\RefBidangLama`.
 */
class RefBidangLamaSearch extends RefBidangLama
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hapus'], 'integer'],
            [['kd_urusan', 'kd_bidang', 'nm_bidang', 'kd_fungsi'], 'safe'],
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
        $query = RefBidangLama::find();

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
            'hapus' => $this->hapus,
        ]);

        $query->andFilterWhere(['like', 'kd_urusan', $this->kd_urusan])
            ->andFilterWhere(['like', 'kd_bidang', $this->kd_bidang])
            ->andFilterWhere(['like', 'nm_bidang', $this->nm_bidang])
            ->andFilterWhere(['like', 'kd_fungsi', $this->kd_fungsi]);

        return $dataProvider;
    }
}
