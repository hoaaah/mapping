<?php

use app\models\RefBidangLama;
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
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'kd_urusan',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'kd_bidang',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nm_bidang',
        'value' => function($model){
            return $model->kd_urusan . "." . $model->kd_bidang . " " . $model->nm_bidang;
        }
    ],
    [
        'label' => 'Perkiraan Klasifikasi Lama',
        'value' => function($model){
            $klasifikasiLama = RefBidangLama::find()->where("nm_bidang LIKE '%{$model->nm_bidang}%'")->one();
            if($klasifikasiLama) return $klasifikasiLama->kd_urusan . "." . $klasifikasiLama->kd_bidang . " " . $klasifikasiLama->nm_bidang;
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
            if($model->id_lama) $klasifikasiLama = RefBidangLama::find()->where(['id' => $model->id_lama])->one();
            if($klasifikasiLama) return $klasifikasiLama->kd_urusan . "." . $klasifikasiLama->kd_bidang . " " . $klasifikasiLama->nm_bidang;
            return '';
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template' => '{view} {update}',
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