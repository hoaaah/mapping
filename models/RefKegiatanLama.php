<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_kegiatan_lama".
 *
 * @property int $id
 * @property int $kd_urusan
 * @property int $kd_bidang
 * @property int $kd_prog
 * @property int $kd_keg
 * @property string|null $ket_kegiatan
 * @property int|null $hapus
 */
class RefKegiatanLama extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_kegiatan_lama';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_urusan', 'kd_bidang', 'kd_prog', 'kd_keg'], 'required'],
            [['kd_urusan', 'kd_bidang', 'kd_prog', 'kd_keg', 'hapus'], 'integer'],
            [['ket_kegiatan'], 'string'],
        ];
    }

    public function delete()
    {
        $this->hapus = 1;
        $this->save();
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
            'hapus' => 'Hapus',
        ];
    }
}
