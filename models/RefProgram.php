<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_program".
 *
 * @property int $id
 * @property int $kd_urusan
 * @property int $kd_bidang
 * @property int $kd_prog
 * @property string|null $ket_program
 * @property int|null $kd_ubah
 * @property int|null $id_lama
 */
class RefProgram extends \yii\db\ActiveRecord
{
    public $kd_ujung;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_program';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_urusan', 'kd_bidang', 'kd_prog'], 'required'],
            [['kd_urusan', 'kd_bidang', 'kd_prog', 'kd_ubah', 'id_lama', 'kd_ujung'], 'integer'],
            [['ket_program'], 'string'],
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // ...custom code here...
        if ($this->kd_ubah == JenisUbah::KD_UBAH_NAMA) {
            $refProgramLama = RefProgramLama::findOne(['kd_urusan' => $this->kd_urusan, 'kd_bidang' => $this->kd_bidang, 'kd_prog' => $this->kd_prog]);
            if ($refProgramLama) $this->id_lama = $refProgramLama->id;
        }
        if($this->kd_ubah == JenisUbah::KD_UBAH_KODE && $this->kd_ujung){
            if(strlen($this->kd_ujung) > 0){
                $refProgramLama = RefProgramLama::findOne(['kd_urusan' => $this->kd_urusan, 'kd_bidang' => $this->kd_bidang, 'kd_prog' => $this->kd_ujung]);
                if ($refProgramLama) $this->id_lama = $refProgramLama->id;
            }
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kd_urusan' => 'Kd Urusan',
            'kd_bidang' => 'Kd Bidang',
            'kd_prog' => 'Kd Prog',
            'ket_program' => 'Ket Program',
            'kd_ubah' => 'Kd Ubah',
            'id_lama' => 'Id Lama',
            'kd_ujung' => 'Kode 1 Digit Terakhir'
        ];
    }

    public function getProgramLama(){
        return $this->hasOne(RefProgramLama::class, ['id' => 'id_lama']);
    }
}
