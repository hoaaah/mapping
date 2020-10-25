<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RefKegiatan;

/**
 * RefKegiatanSearch represents the model behind the search form about `app\models\RefKegiatan`.
 */
class RefKegiatanSearch extends RefKegiatan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'kd_keg', 'kd_ubah', 'id_lama'], 'integer'],
            [['kd_urusan', 'kd_bidang', 'kd_prog', 'ket_kegiatan'], 'safe'],
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
        $query = RefKegiatan::find();

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
            'kd_keg' => $this->kd_keg,
            'kd_ubah' => $this->kd_ubah,
            'id_lama' => $this->id_lama,
        ]);

        $query->andFilterWhere(['like', 'kd_urusan', $this->kd_urusan])
            ->andFilterWhere(['like', 'kd_bidang', $this->kd_bidang])
            ->andFilterWhere(['like', 'kd_prog', $this->kd_prog])
            ->andFilterWhere(['like', 'ket_kegiatan', $this->ket_kegiatan]);

        return $dataProvider;
    }
}
