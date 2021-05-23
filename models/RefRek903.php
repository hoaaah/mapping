<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_rek90_3".
 *
 * @property int $kd_rek90_1
 * @property int $kd_rek90_2
 * @property int $kd_rek90_3
 * @property string|null $nm_rek90_3
 * @property string|null $saldonorm
 */
class RefRek903 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_rek90_3';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_rek90_1', 'kd_rek90_2', 'kd_rek90_3'], 'required'],
            [['kd_rek90_1', 'kd_rek90_2', 'kd_rek90_3'], 'integer'],
            [['nm_rek90_3'], 'string', 'max' => 100],
            [['saldonorm'], 'string', 'max' => 1],
            [['kd_rek90_1', 'kd_rek90_2', 'kd_rek90_3'], 'unique', 'targetAttribute' => ['kd_rek90_1', 'kd_rek90_2', 'kd_rek90_3']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kd_rek90_1' => 'Kd Rek90 1',
            'kd_rek90_2' => 'Kd Rek90 2',
            'kd_rek90_3' => 'Kd Rek90 3',
            'nm_rek90_3' => 'Nm Rek90 3',
            'saldonorm' => 'Saldonorm',
        ];
    }
}
