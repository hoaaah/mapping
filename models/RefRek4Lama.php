<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_rek_4_lama".
 *
 * @property int $id
 * @property int $kd_rek_1
 * @property int $kd_rek_2
 * @property int $kd_rek_3
 * @property int $kd_rek_4
 * @property string|null $nm_rek_4
 * @property int|null $hapus
 */
class RefRek4Lama extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_rek_4_lama';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4'], 'required'],
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'hapus'], 'integer'],
            [['nm_rek_4'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kd_rek_1' => 'Kd Rek 1',
            'kd_rek_2' => 'Kd Rek 2',
            'kd_rek_3' => 'Kd Rek 3',
            'kd_rek_4' => 'Kd Rek 4',
            'nm_rek_4' => 'Nm Rek 4',
            'hapus' => 'Hapus',
        ];
    }
}
