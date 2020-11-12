<?php

use app\models\RefRek3;
use app\models\RefRek4;
use app\models\RefRek4Lama;
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'nm_rek_3',
        'value' => function ($model) {
            return $model->kd_rek_1 . "." . $model->kd_rek_2  . "." . $model->kd_rek_3 . " " . $model->refRek3->nm_rek_3;
        }
    ],
    // [
    //     'label' => 'Rek 3 Lama',
    //     'value' => function ($model) {
    //         if ($model->refRek4->refRek4Lama) return $model->refRek4->refRek4Lama->kd_rek_1 . "." . $model->refRek4->refRek4Lama->kd_rek_2  . "." . $model->refRek4->refRek4Lama->kd_rek_3  . "." . $model->refRek4->refRek4Lama->kd_rek_4 . " " . $model->refRek4->refRek4Lama->nm_rek_4;
    //         return '-';
    //     },
    //     'group' => true,
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'nm_rek_5',
        'value' => function ($model) {
            return $model->kd_rek_1 . "." . $model->kd_rek_2  . "." . $model->kd_rek_3  . "." . $model->kd_rek_4 . " " . $model->nm_rek_4;
        }
    ],
    [
        'label' => 'Perkiraan Klasifikasi Lama',
        'value' => function ($model) {
            $klasifikasiLama = RefRek4Lama::find()->where(['like', 'nm_rek_4', $model->nm_rek_4])->andWhere(['kd_rek_1' => $model->kd_rek_1])->one();
            if ($klasifikasiLama) return $klasifikasiLama->kd_rek_1 . "." . $klasifikasiLama->kd_rek_2  . "." . $klasifikasiLama->kd_rek_3  . "." . $klasifikasiLama->kd_rek_4 . " " . $klasifikasiLama->nm_rek_4;
            return '';
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'kd_ubah',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id_lama',
        'value' => function ($model) {
            $klasifikasiLama = null;
            if ($model->id_lama) $klasifikasiLama = RefRek4Lama::find()->where(['id' => $model->id_lama])->one();
            if ($klasifikasiLama) return $klasifikasiLama->kd_rek_1 . "." . $klasifikasiLama->kd_rek_2  . "." . $klasifikasiLama->kd_rek_3  . "." . $klasifikasiLama->kd_rek_4 . " " . $klasifikasiLama->nm_rek_4;
            return '';
        }
    ],
    [
        'label' => 'KdUbah Data Induk',
        'value' => function ($model) {
            $klasifikasiInduk = RefRek3::find()->where(['kd_rek_1' => $model->kd_rek_1, 'kd_rek_2' => $model->kd_rek_2, 'kd_rek_3' => $model->kd_rek_3])->one();
            return $klasifikasiInduk->kd_ubah;
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'template' => '{view} {update}',
        'vAlign' => 'middle',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },
        'viewOptions' => ['role' => 'modal-remote', 'title' => 'View', 'data-toggle' => 'tooltip'],
        'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'],
        'deleteOptions' => [
            'role' => 'modal-remote', 'title' => 'Delete',
            'data-confirm' => false, 'data-method' => false, // for overide yii data api
            'data-request-method' => 'post',
            'data-toggle' => 'tooltip',
            'data-confirm-title' => 'Are you sure?',
            'data-confirm-message' => 'Are you sure want to delete this item'
        ],
    ],

];
