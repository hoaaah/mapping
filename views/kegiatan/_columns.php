<?php

use app\models\RefKegiatanLama;
use app\models\RefProgram;
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
        'label' => 'Perkiraan Klasifikasi Lama',
        'value' => function($model){
            $klasifikasiLama = RefKegiatanLama::find()->where("ket_kegiatan LIKE '%{$model->ket_kegiatan}%'")->one();
            if($klasifikasiLama) return $klasifikasiLama->kd_urusan . "." . $klasifikasiLama->kd_bidang  . "." . $klasifikasiLama->kd_prog  . "." . $klasifikasiLama->kd_keg . " " . $klasifikasiLama->ket_kegiatan;
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
            if($model->id_lama) $klasifikasiLama = RefKegiatanLama::find()->where(['id' => $model->id_lama])->one();
            if($klasifikasiLama) return $klasifikasiLama->kd_urusan . "." . $klasifikasiLama->kd_bidang  . "." . $klasifikasiLama->kd_prog  . "." . $klasifikasiLama->kd_keg . " " . $klasifikasiLama->ket_kegiatan;
            return '';
        }
    ],
    [
        'label' => 'KdUbah Data Induk',
        'value' => function($model){
            $klasifikasiInduk = RefProgram::find()->where(['kd_urusan' => $model->kd_urusan, 'kd_bidang' => $model->kd_bidang, 'kd_prog' => $model->kd_prog])->one();
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