<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_kegiatan".
 *
 * @property int $id
 * @property int $kd_urusan
 * @property int $kd_bidang
 * @property int $kd_prog
 * @property int $kd_keg
 * @property string|null $ket_kegiatan
 * @property int|null $kd_ubah
 * @property int|null $id_lama
 */
class RefKegiatan extends \yii\db\ActiveRecord
{
    public $kd_ujung;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_kegiatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_urusan', 'kd_bidang', 'kd_prog', 'kd_keg'], 'required'],
            [['kd_urusan', 'kd_bidang', 'kd_prog', 'kd_keg', 'kd_ubah', 'id_lama'], 'integer'],
            [['ket_kegiatan', 'kd_ujung'], 'string'],
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // ...custom code here...
        if ($this->kd_ubah == JenisUbah::KD_UBAH_NAMA) {
            $refKegiatanLama = RefKegiatanLama::findOne(['kd_urusan' => $this->kd_urusan, 'kd_bidang' => $this->kd_bidang, 'kd_prog' => $this->kd_prog, 'kd_keg' => $this->kd_keg]);
            if ($refKegiatanLama) $this->id_lama = $refKegiatanLama->id;
        }
        if($this->kd_ubah == JenisUbah::KD_UBAH_KODE && $this->kd_ujung){
            if(strlen($this->kd_ujung) > 0){
                list($kdProgram, $kdKegiatan) = explode('.', $this->kd_ujung);
                $refKegiatanLama = RefKegiatanLama::findOne(['kd_urusan' => $this->kd_urusan, 'kd_bidang' => $this->kd_bidang, 'kd_prog' => $kdProgram, 'kd_keg' => $kdKegiatan]);
                if ($refKegiatanLama) $this->id_lama = $refKegiatanLama->id;
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
            'kd_keg' => 'Kd Keg',
            'ket_kegiatan' => 'Ket Kegiatan',
            'kd_ubah' => 'Kd Ubah',
            'id_lama' => 'Id Lama',
            'kd_ujung' => 'Kode 2 Digit Terakhir'
        ];
    }

    public function getProgram(){
        return $this->hasOne(RefProgram::class, ['kd_urusan' => 'kd_urusan', 'kd_bidang' => 'kd_bidang', 'kd_prog' => 'kd_prog']);
    }
}
