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
            [['kd_urusan', 'kd_bidang', 'kd_prog', 'kd_ubah', 'id_lama'], 'integer'],
            [['ket_program'], 'string'],
        ];
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
        ];
    }
}
