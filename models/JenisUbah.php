<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jenis_ubah".
 *
 * @property int $id
 * @property string $jenis
 */
class JenisUbah extends \yii\db\ActiveRecord
{

    const KD_UBAH_TAMBAH = 1;
    const KD_UBAH_KODE = 2;
    const KD_UBAH_NAMA = 3;
    const KD_UBAH_HAPUS = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jenis_ubah';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis'], 'required'],
            [['jenis'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jenis' => 'Jenis',
        ];
    }
}
