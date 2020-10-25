<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_bidang".
 *
 * @property int $id
 * @property int $kd_urusan
 * @property int $kd_bidang
 * @property string|null $nm_bidang
 * @property int|null $kd_fungsi
 * @property int|null $kd_ubah
 * @property int|null $id_lama
 */
class RefBidang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_bidang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_urusan', 'kd_bidang'], 'required'],
            [['kd_urusan', 'kd_bidang', 'kd_fungsi', 'kd_ubah', 'id_lama'], 'integer'],
            [['nm_bidang'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kd_urusan' => 'Kd Urusan',
            'kd_bidang' => 'Kd Bidang',
            'nm_bidang' => 'Nm Bidang',
            'kd_fungsi' => 'Kd Fungsi',
            'kd_ubah' => 'Kd Ubah',
            'id_lama' => 'Id Lama',
        ];
    }
}
