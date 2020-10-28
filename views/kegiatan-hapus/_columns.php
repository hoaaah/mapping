<?php

use app\models\RefKegiatan;
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
        'attribute'=>'ket_kegiatan',
        'value' => function($model){
            return $model->kd_urusan . "." . $model->kd_bidang  . "." . $model->kd_prog  . "." . $model->kd_keg . " " . $model->ket_kegiatan;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Klasifikasi Baru',
        'value' => function($model){
            $klasifikasiBaru = RefKegiatan::find()->where(['id_lama' => $model->id])->one();
            if($klasifikasiBaru) return $klasifikasiBaru->kd_urusan . "." . $klasifikasiBaru->kd_bidang  . "." . $klasifikasiBaru->kd_prog  . "." . $klasifikasiBaru->kd_keg . " " . $klasifikasiBaru->ket_kegiatan;
            if(!$klasifikasiBaru){
                $klasifikasiSama = RefKegiatan::find()->where(['ket_kegiatan' => $model->ket_kegiatan])->one();
                if($klasifikasiSama) return $klasifikasiSama->kd_urusan . "." . $klasifikasiSama->kd_bidang  . "." . $klasifikasiSama->kd_prog  . "." . $klasifikasiSama->kd_keg . " " . $klasifikasiSama->ket_kegiatan;
            }
            return '';
        }
    ],
    'hapus',
    [
        'label' => 'KdUbah Data Induk',
        'value' => function($model){
            $klasifikasiInduk = RefProgramLama::find()->where(['kd_urusan' => $model->kd_urusan, 'kd_bidang' => $model->kd_bidang, 'kd_prog' => $model->kd_prog])->one();
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