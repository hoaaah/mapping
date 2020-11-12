<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_rek_5".
 *
 * @property int $id
 * @property int $kd_rek_1
 * @property int $kd_rek_2
 * @property int $kd_rek_3
 * @property int $kd_rek_4
 * @property int $kd_rek_5
 * @property string|null $nm_rek_5
 * @property string|null $peraturan
 * @property int|null $kd_ubah
 * @property int|null $id_lama
 *
 * @property RefRek4 $kdRek1
 */
class RefRek5 extends \yii\db\ActiveRecord
{
    public $kd_ujung;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_rek_5';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_rek_5'], 'required'],
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_rek_5', 'kd_ubah', 'id_lama'], 'integer'],
            [['nm_rek_5', 'kd_ujung'], 'string', 'max' => 255],
            [['peraturan'], 'string', 'max' => 50],
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_rek_5'], 'unique', 'targetAttribute' => ['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_rek_5']],
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4'], 'exist', 'skipOnError' => true, 'targetClass' => RefRek4::className(), 'targetAttribute' => ['kd_rek_1' => 'kd_rek_1', 'kd_rek_2' => 'kd_rek_2', 'kd_rek_3' => 'kd_rek_3', 'kd_rek_4' => 'kd_rek_4']],
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
            'kd_rek_5' => 'Kd Rek 5',
            'nm_rek_5' => 'Nm Rek 5',
            'peraturan' => 'Peraturan',
            'kd_ubah' => 'Kd Ubah',
            'id_lama' => 'Id Lama',
            'kd_ujung' => 'Kode 3 Digit Terakhir'
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // ...custom code here...
        if ($this->kd_ubah == JenisUbah::KD_UBAH_NAMA) {
            $refRek5Lama = RefRek5Lama::findOne(['kd_rek_1' => $this->kd_rek_1, 'kd_rek_2' => $this->kd_rek_2, 'kd_rek_3' => $this->kd_rek_3, 'kd_rek_4' => $this->kd_rek_4, 'kd_rek_5' => $this->kd_rek_5]);
            if ($refRek5Lama) $this->id_lama = $refRek5Lama->id;
        }
        if ($this->kd_ubah == JenisUbah::KD_UBAH_KODE && $this->kd_ujung) {
            if (strlen($this->kd_ujung) > 0) {
                list($kdRek3, $kdRek4, $kdRek5) = explode('.', $this->kd_ujung);
                if (strlen($kdRek3) > 0  && strlen($kdRek4) > 0 && $kdRek4 != '_' && strlen($kdRek5) > 0 && $kdRek5 != '_') {
                    $refRek5Lama = RefRek5Lama::findOne(['kd_rek_1' => $this->kd_rek_1, 'kd_rek_2' => $this->kd_rek_2, 'kd_rek_3' => $kdRek3, 'kd_rek_4' => $kdRek4, 'kd_rek_5' => $kdRek5]);
                    if ($refRek5Lama) $this->id_lama = $refRek5Lama->id;
                } else {
                    $refRek5Lama = RefRek5Lama::findOne(['kd_rek_1' => $this->kd_rek_1, 'kd_rek_2' => $this->kd_rek_2, 'kd_rek_3' => $kdRek3, 'kd_rek_4' => $kdRek4, 'kd_rek_5' => $this->kd_rek_5]);
                    if ($refRek5Lama) $this->id_lama = $refRek5Lama->id;
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
    public function getRefRek4()
    {
        return $this->hasOne(RefRek4::className(), ['kd_rek_1' => 'kd_rek_1', 'kd_rek_2' => 'kd_rek_2', 'kd_rek_3' => 'kd_rek_3', 'kd_rek_4' => 'kd_rek_4']);
    }
}
