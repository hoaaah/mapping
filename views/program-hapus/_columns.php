<?php

use app\models\RefBidang;
use app\models\RefBidangLama;
use app\models\RefProgram;
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
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Klasifikasi Baru',
        'value' => function($model){
            $klasifikasiBaru = RefProgram::find()->where(['id_lama' => $model->id])->one();
            if($klasifikasiBaru) return $klasifikasiBaru->kd_urusan . "." . $klasifikasiBaru->kd_bidang  . "." . $klasifikasiBaru->kd_prog . " " . $klasifikasiBaru->ket_program;
            return '';
        }
    ],
    'hapus',
    [
        'label' => 'KdUbah Data Induk',
        'value' => function($model){
            $klasifikasiInduk = RefBidangLama::find()->where(['kd_urusan' => $model->kd_urusan, 'kd_bidang' => $model->kd_bidang])->one();
            return $klasifikasiInduk->hapus;
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{view} {update} {delete}',
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