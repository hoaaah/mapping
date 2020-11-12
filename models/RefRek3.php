<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_rek_3".
 *
 * @property int $id
 * @property int $kd_rek_1
 * @property int $kd_rek_2
 * @property int $kd_rek_3
 * @property string|null $nm_rek_3
 * @property string|null $saldonorm
 * @property int|null $kd_ubah
 * @property int|null $id_lama
 *
 * @property RefRek4[] $refRek4s
 */
class RefRek3 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_rek_3';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3'], 'required'],
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_ubah', 'id_lama'], 'integer'],
            [['nm_rek_3'], 'string', 'max' => 100],
            [['saldonorm'], 'string', 'max' => 1],
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3'], 'unique', 'targetAttribute' => ['kd_rek_1', 'kd_rek_2', 'kd_rek_3']],
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
            'nm_rek_3' => 'Nm Rek 3',
            'saldonorm' => 'Saldonorm',
            'kd_ubah' => 'Kd Ubah',
            'id_lama' => 'Id Lama',
        ];
    }

    /**
     * Gets query for [[RefRek4s]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRefRek4s()
    {
        return $this->hasMany(RefRek4::className(), ['kd_rek_1' => 'kd_rek_1', 'kd_rek_2' => 'kd_rek_2', 'kd_rek_3' => 'kd_rek_3']);
    }
}
