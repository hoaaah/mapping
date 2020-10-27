<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefProgram;

/**
 * RefProgramSearch represents the model behind the search form about `app\models\RefProgram`.
 */
class RefProgramSearch extends RefProgram
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'kd_ubah', 'id_lama'], 'integer'],
            [['kd_urusan', 'kd_bidang', 'kd_prog', 'ket_program'], 'safe'],
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
        $query = RefProgram::find();

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
            'kd_urusan' => $this->kd_urusan,
            'kd_bidang' => $this->kd_bidang,
            'kd_prog' => $this->kd_prog,
        ]);

        $query->andFilterWhere(['like', 'ket_program', $this->ket_program]);

        return $dataProvider;
    }
}
