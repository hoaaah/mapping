<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_rek90_4".
 *
 * @property int $kd_rek90_1
 * @property int $kd_rek90_2
 * @property int $kd_rek90_3
 * @property int $kd_rek90_4
 * @property string|null $nm_rek90_4
 */
class RefRek904 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_rek90_4';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_rek90_1', 'kd_rek90_2', 'kd_rek90_3', 'kd_rek90_4'], 'required'],
            [['kd_rek90_1', 'kd_rek90_2', 'kd_rek90_3', 'kd_rek90_4'], 'integer'],
            [['nm_rek90_4'], 'string', 'max' => 255],
            [['kd_rek90_1', 'kd_rek90_2', 'kd_rek90_3', 'kd_rek90_4'], 'unique', 'targetAttribute' => ['kd_rek90_1', 'kd_rek90_2', 'kd_rek90_3', 'kd_rek90_4']],
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
            'kd_rek90_4' => 'Kd Rek90 4',
            'nm_rek90_4' => 'Nm Rek90 4',
        ];
    }
}
