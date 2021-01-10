<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_akrual_3".
 *
 * @property int $kd_akrual_1
 * @property int $kd_akrual_2
 * @property int $kd_akrual_3
 * @property string $nm_akrual_3
 * @property string $saldonorm
 *
 * @property RefAkrual2 $kdAkrual1
 * @property RefAkrual4[] $refAkrual4s
 */
class RefAkrual3 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_akrual_3';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3', 'nm_akrual_3', 'saldonorm'], 'required'],
            [['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3'], 'integer'],
            [['nm_akrual_3'], 'string', 'max' => 100],
            [['saldonorm'], 'string', 'max' => 1],
            [['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3'], 'unique', 'targetAttribute' => ['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3']],
            [['kd_akrual_1', 'kd_akrual_2'], 'exist', 'skipOnError' => true, 'targetClass' => RefAkrual2::className(), 'targetAttribute' => ['kd_akrual_1' => 'kd_akrual_1', 'kd_akrual_2' => 'kd_akrual_2']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kd_akrual_1' => 'Kd Akrual 1',
            'kd_akrual_2' => 'Kd Akrual 2',
            'kd_akrual_3' => 'Kd Akrual 3',
            'nm_akrual_3' => 'Nm Akrual 3',
            'saldonorm' => 'Saldonorm',
        ];
    }

    /**
     * Gets query for [[KdAkrual1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKdAkrual1()
    {
        return $this->hasOne(RefAkrual2::className(), ['kd_akrual_1' => 'kd_akrual_1', 'kd_akrual_2' => 'kd_akrual_2']);
    }

    /**
     * Gets query for [[RefAkrual4s]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRefAkrual4s()
    {
        return $this->hasMany(RefAkrual4::className(), ['kd_akrual_1' => 'kd_akrual_1', 'kd_akrual_2' => 'kd_akrual_2', 'kd_akrual_3' => 'kd_akrual_3']);
    }
}
