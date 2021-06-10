<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_mapping_sa".
 *
 * @property int $kd_rek90_1
 * @property int $kd_rek90_2
 * @property int $kd_rek90_3
 * @property int $kd_rek90_4
 * @property int $kd_rek90_5
 * @property int $kd_rek90_6
 * @property int|null $kd_rek_1
 * @property int|null $kd_rek_2
 * @property int|null $kd_rek_3
 * @property int|null $kd_rek_4
 * @property int|null $kd_rek_5
 */
class RefMappingSa extends \yii\db\ActiveRecord
{

    public $rekening_akrual, $rekening_mapping1, $rekening_mapping2, $rekening90;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_mapping_sa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_rek90_1', 'kd_rek90_2', 'kd_rek90_3', 'kd_rek90_4', 'kd_rek90_5', 'kd_rek90_6'], 'required'],
            [['rekening_akrual', 'rekening_mapping1', 'rekening_mapping2', 'rekening90'], 'string'],
            [['kd_rek90_1', 'kd_rek90_2', 'kd_rek90_3', 'kd_rek90_4', 'kd_rek90_5', 'kd_rek90_6', 'kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_rek_5'], 'integer'],
            // [['kd_rek90_1', 'kd_rek90_2', 'kd_rek90_3', 'kd_rek90_4', 'kd_rek90_5', 'kd_rek90_6'], 'unique', 'targetAttribute' => ['kd_rek90_1', 'kd_rek90_2', 'kd_rek90_3', 'kd_rek90_4', 'kd_rek90_5', 'kd_rek90_6']],
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
            'kd_rek90_6' => 'Kd Rek90 6',
            'kd_rek_1' => 'Kd Rek 1',
            'kd_rek_2' => 'Kd Rek 2',
            'kd_rek_3' => 'Kd Rek 3',
            'kd_rek_4' => 'Kd Rek 4',
            'kd_rek_5' => 'Kd Rek 5',
        ];
    }

    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        if ($this->rekening_akrual && $this->rekening_akrual != '') list($this->kd_rek_1, $this->kd_rek_2, $this->kd_rek_3, $this->kd_rek_4, $this->kd_rek_5) = explode(".", $this->rekening_akrual);
        if ($this->rekening90 && $this->rekening90 != '') list($this->kd_rek90_1, $this->kd_rek90_2, $this->kd_rek90_3, $this->kd_rek90_4, $this->kd_rek90_5, $this->kd_rek90_6) = explode('.', $this->rekening90);

        return true;
    }

    /**
     * Gets query for [[KdAkrual1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMappingAkrual()
    {
        return $this->hasOne(RefAkrual5::class, ['kd_akrual_1' => 'kd_rek_1', 'kd_akrual_2' => 'kd_rek_2', 'kd_akrual_3' => 'kd_rek_3', 'kd_akrual_4' => 'kd_rek_4', 'kd_akrual_5' => 'kd_rek_5']);
    }

    /**
     * Gets query for [[KdRek1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRefRek5()
    {
        return $this->hasOne(RefRek906::class, [
            'kd_rek90_1' => 'kd_rek90_1',
            'kd_rek90_2' => 'kd_rek90_2',
            'kd_rek90_3' => 'kd_rek90_3',
            'kd_rek90_4' => 'kd_rek90_4',
            'kd_rek90_5' => 'kd_rek90_5',
            'kd_rek90_6' => 'kd_rek90_6'
        ]);
    }
}
