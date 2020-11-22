<?php

use app\models\RefRek4Lama;
use app\models\RefRek5;
use app\models\RefRek5Lama;
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
        'attribute'=>'nm_rek_5',
        'value' => function($model){
            return $model->kd_rek_1 . "." . $model->kd_rek_2  . "." . $model->kd_rek_3  . "." . $model->kd_rek_4  . "." . $model->kd_rek_5 . " " . $model->nm_rek_5;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Klasifikasi Baru',
        'value' => function($model){
            $klasifikasiBaru = RefRek5::find()->where(['id_lama' => $model->id])->one();
            if($klasifikasiBaru) return $klasifikasiBaru->kd_rek_1 . "." . $klasifikasiBaru->kd_rek_2  . "." . $klasifikasiBaru->kd_rek_3  . "." . $klasifikasiBaru->kd_rek_4  . "." . $klasifikasiBaru->kd_rek_5 . " " . $klasifikasiBaru->nm_rek_5;
            if(!$klasifikasiBaru){
                $klasifikasiSama = RefRek5::find()->where(['nm_rek_5' => $model->nm_rek_5])->one();
                if($klasifikasiSama) return $klasifikasiSama->kd_rek_1 . "." . $klasifikasiSama->kd_rek_2  . "." . $klasifikasiSama->kd_rek_3  . "." . $klasifikasiSama->kd_rek_4  . "." . $klasifikasiSama->kd_rek_5 . " " . $klasifikasiSama->nm_rek_5;
            }
            return '';
        }
    ],
    'hapus',
    [
        'label' => 'KdUbah Data Induk',
        'value' => function($model){
            $klasifikasiInduk = RefRek4Lama::find()->where(['kd_rek_1' => $model->kd_rek_1, 'kd_rek_2' => $model->kd_rek_2, 'kd_rek_3' => $model->kd_rek_3, 'kd_rek_4' => $model->kd_rek_4])->one();
            return $klasifikasiInduk->hapus;
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => ' {delete}', // {view} {update}
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