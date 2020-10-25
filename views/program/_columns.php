<?php

use app\models\RefBidang;
use app\models\RefProgramLama;
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
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ket_program',
        'value' => function($model){
            return $model->kd_urusan . "." . $model->kd_bidang  . "." . $model->kd_prog . " " . $model->ket_program;
        }
    ],
    [
        'label' => 'Perkiraan Klasifikasi Lama',
        'value' => function($model){
            $klasifikasiLama = RefProgramLama::find()->where("ket_program LIKE '%{$model->ket_program}%'")->one();
            if($klasifikasiLama) return $klasifikasiLama->kd_urusan . "." . $klasifikasiLama->kd_bidang  . "." . $klasifikasiLama->kd_prog . " " . $klasifikasiLama->ket_program;
            return '';
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'kd_ubah',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_lama',
        'value' => function($model){
            $klasifikasiLama = null;
            if($model->id_lama) $klasifikasiLama = RefProgramLama::find()->where(['id' => $model->id_lama])->one();
            if($klasifikasiLama) return $klasifikasiLama->kd_urusan . "." . $klasifikasiLama->kd_bidang  . "." . $klasifikasiLama->kd_prog . " " . $klasifikasiLama->ket_program;
            return '';
        }
    ],
    [
        'label' => 'KdUbah Data Induk',
        'value' => function($model){
            $klasifikasiInduk = RefBidang::find()->where(['kd_urusan' => $model->kd_urusan, 'kd_bidang' => $model->kd_bidang])->one();
            return $klasifikasiInduk->kd_ubah;
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'template' => '{view} {update}',
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   