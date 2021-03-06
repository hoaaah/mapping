<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_akrual_5".
 *
 * @property int $kd_akrual_1
 * @property int $kd_akrual_2
 * @property int $kd_akrual_3
 * @property int $kd_akrual_4
 * @property int $kd_akrual_5
 * @property string $nm_akrual_5
 * @property string|null $peraturan
 *
 * @property RefAkrual4 $kdAkrual1
 * @property RefAkrualRek[] $refAkrualReks
 */
class RefAkrual5 extends \yii\db\ActiveRecord
{

    public $kd_ujung, $tambah_sisip, $kode_akrual, $kode_mapping_1, $kode_mapping_2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_akrual_5';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3', 'kd_akrual_4', 'kd_akrual_5', 'nm_akrual_5'], 'required'],
            [['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3', 'kd_akrual_4', 'kd_akrual_5', 'tambah_sisip'], 'integer'],
            [['nm_akrual_5', 'kd_ujung', 'kode_akrual', 'kode_mapping_1', 'kode_mapping_2'], 'string', 'max' => 255],
            [['peraturan'], 'string', 'max' => 50],
            [['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3', 'kd_akrual_4', 'kd_akrual_5'], 'unique', 'targetAttribute' => ['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3', 'kd_akrual_4', 'kd_akrual_5']],
            [['kd_akrual_1', 'kd_akrual_2', 'kd_akrual_3', 'kd_akrual_4'], 'exist', 'skipOnError' => true, 'targetClass' => RefAkrual4::className(), 'targetAttribute' => ['kd_akrual_1' => 'kd_akrual_1', 'kd_akrual_2' => 'kd_akrual_2', 'kd_akrual_3' => 'kd_akrual_3', 'kd_akrual_4' => 'kd_akrual_4']],
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
            'kd_akrual_4' => 'Kd Akrual 4',
            'kd_akrual_5' => 'Kd Akrual 5',
            'nm_akrual_5' => 'Nm Akrual 5',
            'peraturan' => 'Peraturan',
        ];
    }

    public function getRek5Code()
    {
        return $this->kd_akrual_1 . '.' . $this->kd_akrual_2 . '.' . substr("00" . $this->kd_akrual_3, -2) . '.' . substr("00" . $this->kd_akrual_4, -2) . '.' . substr("000" . $this->kd_akrual_5, -3);
    }

    public function getRek5TextWithCode()
    {
        return $this->kd_akrual_1 . '.' . $this->kd_akrual_2 . '.' . substr("00" . $this->kd_akrual_3, -2) . '.' . substr("00" . $this->kd_akrual_4, -2) . '.' . substr("000" . $this->kd_akrual_5, -3) . ' ' . $this->refAkrual4->nm_akrual_4  . ' - ' . $this->nm_akrual_5;
    }


    /**
     * Gets query for [[KdAkrual1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRefAkrual4()
    {
        return $this->hasOne(RefAkrual4::className(), ['kd_akrual_1' => 'kd_akrual_1', 'kd_akrual_2' => 'kd_akrual_2', 'kd_akrual_3' => 'kd_akrual_3', 'kd_akrual_4' => 'kd_akrual_4']);
    }

    /**
     * Gets query for [[RefAkrualReks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRefAkrualReks()
    {
        return $this->hasMany(RefAkrualRek::className(), ['kd_akrual_1' => 'kd_akrual_1', 'kd_akrual_2' => 'kd_akrual_2', 'kd_akrual_3' => 'kd_akrual_3', 'kd_akrual_4' => 'kd_akrual_4', 'kd_akrual_5' => 'kd_akrual_5']);
    }

    public function getRefMappingSa()
    {
        return $this->hasOne(RefMappingSa::class, ['kd_rek_1' => 'kd_akrual_1', 'kd_rek_2' => 'kd_akrual_2', 'kd_rek_3' => 'kd_akrual_3', 'kd_rek_4' => 'kd_akrual_4', 'kd_rek_5' => 'kd_akrual_5']);
    }
}
