<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_rek90_5".
 *
 * @property int $kd_rek90_1
 * @property int $kd_rek90_2
 * @property int $kd_rek90_3
 * @property int $kd_rek90_4
 * @property int $kd_rek90_5
 * @property string|null $nm_rek90_5
 * @property string|null $peraturan
 */
class RefRek905 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_rek90_5';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_rek90_1', 'kd_rek90_2', 'kd_rek90_3', 'kd_rek90_4', 'kd_rek90_5'], 'required'],
            [['kd_rek90_1', 'kd_rek90_2', 'kd_rek90_3', 'kd_rek90_4', 'kd_rek90_5'], 'integer'],
            [['nm_rek90_5'], 'string', 'max' => 255],
            [['peraturan'], 'string', 'max' => 50],
            [['kd_rek90_1', 'kd_rek90_2', 'kd_rek90_3', 'kd_rek90_4', 'kd_rek90_5'], 'unique', 'targetAttribute' => ['kd_rek90_1', 'kd_rek90_2', 'kd_rek90_3', 'kd_rek90_4', 'kd_rek90_5']],
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
            'kd_rek90_5' => 'Kd Rek90 5',
            'nm_rek90_5' => 'Nm Rek90 5',
            'peraturan' => 'Peraturan',
        ];
    }
}
