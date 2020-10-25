<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_program_lama".
 *
 * @property int $id
 * @property int $kd_urusan
 * @property int $kd_bidang
 * @property int $kd_prog
 * @property string|null $ket_program
 * @property int|null $hapus
 */
class RefProgramLama extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_program_lama';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_urusan', 'kd_bidang', 'kd_prog'], 'required'],
            [['kd_urusan', 'kd_bidang', 'kd_prog', 'hapus'], 'integer'],
            [['ket_program'], 'string'],
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
            'ket_program' => 'Ket Program',
            'hapus' => 'Hapus',
        ];
    }
}
