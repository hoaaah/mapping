<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_rek_4".
 *
 * @property int $id
 * @property int $kd_rek_1
 * @property int $kd_rek_2
 * @property int $kd_rek_3
 * @property int $kd_rek_4
 * @property string|null $nm_rek_4
 * @property int|null $kd_ubah
 * @property int|null $id_lama
 *
 * @property RefRek3 $kdRek1
 * @property RefRek5[] $refRek5s
 */
class RefRek4 extends \yii\db\ActiveRecord
{
    public $kd_ujung, $tambah_sisip;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_rek_4';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4'], 'required'],
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_ubah', 'id_lama'], 'integer'],
            [['nm_rek_4', 'kd_ujung'], 'string', 'max' => 100],
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4'], 'unique', 'targetAttribute' => ['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4']],
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3'], 'exist', 'skipOnError' => true, 'targetClass' => RefRek3::className(), 'targetAttribute' => ['kd_rek_1' => 'kd_rek_1', 'kd_rek_2' => 'kd_rek_2', 'kd_rek_3' => 'kd_rek_3']],
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
            'kd_ubah' => 'Kd Ubah',
            'id_lama' => 'Id Lama',
            'kd_ujung' => 'Kode 2 Digit Terakhir'
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // ...custom code here...
        if ($this->kd_ubah == JenisUbah::KD_UBAH_NAMA) {
            $refRek4Lama = RefRek4Lama::findOne(['kd_rek_1' => $this->kd_rek_1, 'kd_rek_2' => $this->kd_rek_2, 'kd_rek_3' => $this->kd_rek_3, 'kd_rek_4' => $this->kd_rek_4]);
            if ($refRek4Lama) $this->id_lama = $refRek4Lama->id;
        }
        if ($this->kd_ubah == JenisUbah::KD_UBAH_KODE && $this->tambah_sisip) {
            if(strlen($this->tambah_sisip) > 0){
                $refRek4Lama = RefRek4Lama::findOne(['kd_rek_1' => $this->kd_rek_1, 'kd_rek_2' => $this->kd_rek_2, 'kd_rek_3' => $this->kd_rek_3, 'kd_rek_4' => ($this->kd_rek_4 + (int) $this->tambah_sisip)]);
                if ($refRek4Lama) $this->id_lama = $refRek4Lama->id;
            }
        }
        if ($this->kd_ubah == JenisUbah::KD_UBAH_KODE && $this->kd_ujung) {
            if (strlen($this->kd_ujung) > 0) {
                list($kdRek3, $kdRek4) = explode('.', $this->kd_ujung);
                if (strlen($kdRek3) > 0  && strlen($kdRek4) > 0 && $kdRek4 != '_') {
                    $refRek4Lama = RefRek4Lama::findOne(['kd_rek_1' => $this->kd_rek_1, 'kd_rek_2' => $this->kd_rek_2, 'kd_rek_3' => $kdRek3, 'kd_rek_4' => ($kdRek4 + (int) $this->tambah_sisip)]);
                    if ($refRek4Lama) $this->id_lama = $refRek4Lama->id;
                } else {
                    $refRek4Lama = RefRek4Lama::findOne(['kd_rek_1' => $this->kd_rek_1, 'kd_rek_2' => $this->kd_rek_2, 'kd_rek_3' => $kdRek3, 'kd_rek_4' => ($this->kd_rek_4 + (int) $this->tambah_sisip)]);
                    if ($refRek4Lama) $this->id_lama = $refRek4Lama->id;
                }
            }
        }
        return true;
    }

    /**
     * Gets query for [[KdRek1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRefRek3()
    {
        return $this->hasOne(RefRek3::className(), ['kd_rek_1' => 'kd_rek_1', 'kd_rek_2' => 'kd_rek_2', 'kd_rek_3' => 'kd_rek_3']);
    }

    /**
     * Gets query for [[RefRek5s]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRefRek5s()
    {
        return $this->hasMany(RefRek5::className(), ['kd_rek_1' => 'kd_rek_1', 'kd_rek_2' => 'kd_rek_2', 'kd_rek_3' => 'kd_rek_3', 'kd_rek_4' => 'kd_rek_4']);
    }

    public function getRefRek4Lama()
    {
        return $this->hasOne(RefRek4Lama::class, ['id' => 'id_lama']);
    }
}
