<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_rek_5_lama".
 *
 * @property int $id
 * @property int $kd_rek_1
 * @property int $kd_rek_2
 * @property int $kd_rek_3
 * @property int $kd_rek_4
 * @property int $kd_rek_5
 * @property string|null $nm_rek_5
 * @property string|null $peraturan
 * @property int|null $hapus
 */
class RefRek5Lama extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_rek_5_lama';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_rek_5'], 'required'],
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_rek_5', 'hapus'], 'integer'],
            [['nm_rek_5'], 'string', 'max' => 255],
            [['peraturan'], 'string', 'max' => 50],
            [['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_rek_5'], 'unique', 'targetAttribute' => ['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_rek_5']],
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
            'kd_rek_1' => 'Kd Rek 1',
            'kd_rek_2' => 'Kd Rek 2',
            'kd_rek_3' => 'Kd Rek 3',
            'kd_rek_4' => 'Kd Rek 4',
            'kd_rek_5' => 'Kd Rek 5',
            'nm_rek_5' => 'Nm Rek 5',
            'peraturan' => 'Peraturan',
            'hapus' => 'Hapus',
        ];
    }
}
