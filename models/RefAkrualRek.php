<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_akrual_rek".
 *
 * @property int $kd_rek_1
 * @property int $kd_rek_2
 * @property int $kd_rek_3
 * @property int $kd_rek_4
 * @property int $kd_rek_5
 * @property int $kd_akrual_1
 * @property int $kd_akrual_2
 * @property int $kd_akrual_3
 * @property int $kd_akrual_4
 * @property int $kd_akrual_5
 * @property int|null $kd_akruald_1
 * @property int|null $kd_akruald_2
 * @property int|null $kd_akruald_3
 * @property int|null $kd_akruald_4
 * @property int|null $kd_akruald_5
 * @property int|null $kd_akrualk_1
 * @property int|null $kd_akrualk_2
 * @property int|null $kd_akrualk_3
 * @property int|null $kd_akrualk_4
 * @property int|null $kd_akrualk_5
 *
 * @property RefAkrual5 $kdAkrual1
 * @property RefRek5 $kdRek1
 */
class RefAkrualRek extends \yii\db\ActiveRecord
{

    public $rekening_akrual, $rekening_mapping1, $rekening_mapping2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_akrual_rek';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_rek_5', 'kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3', 'kd_akrual_4', 'kd_akrual_5'], 'required'],
            [['rekening_akrual', 'rekening_mapping1', 'rekening_mapping2'], 'string'],
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_rek_5', 'kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3', 'kd_akrual_4', 'kd_akrual_5', 'kd_akruald_1', 'kd_akruald_2', 'kd_akruald_3', 'kd_akruald_4', 'kd_akruald_5', 'kd_akrualk_1', 'kd_akrualk_2', 'kd_akrualk_3', 'kd_akrualk_4', 'kd_akrualk_5'], 'integer'],
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_rek_5'], 'unique', 'targetAttribute' => ['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_rek_5']],
            [['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3', 'kd_akrual_4', 'kd_akrual_5'], 'exist', 'skipOnError' => true, 'targetClass' => RefAkrual5::className(), 'targetAttribute' => ['kd_akrual_1' => 'kd_akrual_1', 'kd_akrual_2' => 'kd_akrual_2', 'kd_akrual_3' => 'kd_akrual_3', 'kd_akrual_4' => 'kd_akrual_4', 'kd_akrual_5' => 'kd_akrual_5']],
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_rek_5'], 'exist', 'skipOnError' => true, 'targetClass' => RefRek5::className(), 'targetAttribute' => ['kd_rek_1' => 'kd_rek_1', 'kd_rek_2' => 'kd_rek_2', 'kd_rek_3' => 'kd_rek_3', 'kd_rek_4' => 'kd_rek_4', 'kd_rek_5' => 'kd_rek_5']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kd_rek_1' => 'Kd Rek 1',
            'kd_rek_2' => 'Kd Rek 2',
            'kd_rek_3' => 'Kd Rek 3',
            'kd_rek_4' => 'Kd Rek 4',
            'kd_rek_5' => 'Kd Rek 5',
            'kd_akrual_1' => 'Kd Akrual 1',
            'kd_akrual_2' => 'Kd Akrual 2',
            'kd_akrual_3' => 'Kd Akrual 3',
            'kd_akrual_4' => 'Kd Akrual 4',
            'kd_akrual_5' => 'Kd Akrual 5',
            'kd_akruald_1' => 'Kd Akruald 1',
            'kd_akruald_2' => 'Kd Akruald 2',
            'kd_akruald_3' => 'Kd Akruald 3',
            'kd_akruald_4' => 'Kd Akruald 4',
            'kd_akruald_5' => 'Kd Akruald 5',
            'kd_akrualk_1' => 'Kd Akrualk 1',
            'kd_akrualk_2' => 'Kd Akrualk 2',
            'kd_akrualk_3' => 'Kd Akrualk 3',
            'kd_akrualk_4' => 'Kd Akrualk 4',
            'kd_akrualk_5' => 'Kd Akrualk 5',
        ];
    }

    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        if ($this->rekening_akrual && $this->rekening_akrual != '') list($this->kd_akrual_1, $this->kd_akrual_2, $this->kd_akrual_3, $this->kd_akrual_4, $this->kd_akrual_5) = explode(".", $this->rekening_akrual);

        if ($this->rekening_mapping1 && $this->rekening_mapping1 != '') list($this->kd_akruald_1, $this->kd_akruald_2, $this->kd_akruald_3, $this->kd_akruald_4, $this->kd_akruald_5) = explode(".", $this->rekening_mapping1);

        if ($this->rekening_mapping2 && $this->rekening_mapping2 != '') list($this->kd_akrualk_1, $this->kd_akrualk_2, $this->kd_akrualk_3, $this->kd_akrualk_4, $this->kd_akrualk_5) = explode(".", $this->rekening_mapping2);

        return true;
    }

    /**
     * Gets query for [[KdAkrual1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMappingAkrual()
    {
        return $this->hasOne(RefAkrual5::class, ['kd_akrual_1' => 'kd_akrual_1', 'kd_akrual_2' => 'kd_akrual_2', 'kd_akrual_3' => 'kd_akrual_3', 'kd_akrual_4' => 'kd_akrual_4', 'kd_akrual_5' => 'kd_akrual_5']);
    }

    public function getMapping1()
    {
        return $this->hasOne(RefAkrual5::class, ['kd_akrual_1' => 'kd_akruald_1', 'kd_akrual_2' => 'kd_akruald_2', 'kd_akrual_3' => 'kd_akruald_3', 'kd_akrual_4' => 'kd_akruald_4', 'kd_akrual_5' => 'kd_akruald_5']);
    }

    public function getMapping2()
    {
        return $this->hasOne(RefAkrual5::class, ['kd_akrual_1' => 'kd_akrualk_1', 'kd_akrual_2' => 'kd_akrualk_2', 'kd_akrual_3' => 'kd_akrualk_3', 'kd_akrual_4' => 'kd_akrualk_4', 'kd_akrual_5' => 'kd_akrualk_5']);
    }

    /**
     * Gets query for [[KdRek1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRefRek5()
    {
        return $this->hasOne(RefRek5::class, ['kd_rek_1' => 'kd_rek_1', 'kd_rek_2' => 'kd_rek_2', 'kd_rek_3' => 'kd_rek_3', 'kd_rek_4' => 'kd_rek_4', 'kd_rek_5' => 'kd_rek_5']);
    }
}
