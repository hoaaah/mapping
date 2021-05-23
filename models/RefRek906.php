<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_rek90_6".
 *
 * @property int $kd_rek90_1
 * @property int $kd_rek90_2
 * @property int $kd_rek90_3
 * @property int $kd_rek90_4
 * @property int $kd_rek90_5
 * @property int $kd_rek90_6
 * @property string|null $nm_rek90_6
 * @property string|null $peraturan
 */
class RefRek906 extends \yii\db\ActiveRecord
{

    public $kd_ujung, $tambah_sisip, $kode_akrual, $kode_mapping_1, $kode_mapping_2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_rek90_6';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_rek90_1', 'kd_rek90_2', 'kd_rek90_3', 'kd_rek90_4', 'kd_rek90_5', 'kd_rek90_6'], 'required'],
            [['kd_rek90_1', 'kd_rek90_2', 'kd_rek90_3', 'kd_rek90_4', 'kd_rek90_5', 'kd_rek90_6', 'tambah_sisip'], 'integer'],
            [['nm_rek90_6', 'kd_ujung', 'kode_akrual', 'kode_mapping_1', 'kode_mapping_2'], 'string', 'max' => 255],
            [['peraturan'], 'string', 'max' => 50],
            [['kd_rek90_1', 'kd_rek90_2', 'kd_rek90_3', 'kd_rek90_4', 'kd_rek90_5', 'kd_rek90_6'], 'unique', 'targetAttribute' => ['kd_rek90_1', 'kd_rek90_2', 'kd_rek90_3', 'kd_rek90_4', 'kd_rek90_5', 'kd_rek90_6']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kd_rek90_1' => 'Kd Rek90 1',
            'kd_rek90_2' => 'Kd Rek90 2',
            'kd_rek90_3' => 'Kd Rek90 3',
            'kd_rek90_4' => 'Kd Rek90 4',
            'kd_rek90_5' => 'Kd Rek90 5',
            'kd_rek90_6' => 'Kd Rek90 6',
            'nm_rek90_6' => 'Nm Rek90 6',
            'peraturan' => 'Peraturan',
        ];
    }

    public function getRek5TextWithCode()
    {
        return $this->kd_rek90_1 . '.' . $this->kd_rek90_2 . '.' . substr("00" . $this->kd_rek90_3, -2) . '.' . substr("00" . $this->kd_rek90_4, -2) . '.' . substr("00" . $this->kd_rek90_5, -2) . '.' . substr("000" . $this->kd_rek90_6, -3) . ' ' . $this->nm_rek90_6;
    }

    public function getRefAkrualRek()
    {
        return $this->hasOne(RefMappingSa::class, ['kd_rek90_1' => 'kd_rek90_1', 'kd_rek90_2' => 'kd_rek90_2', 'kd_rek90_3' => 'kd_rek90_3', 'kd_rek90_4' => 'kd_rek90_4', 'kd_rek90_5' => 'kd_rek90_5', 'kd_rek90_6' => 'kd_rek90_6']);
    }
}
