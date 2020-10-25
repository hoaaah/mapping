<?php

use app\models\RefBidang;
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
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Klasifikasi Baru',
        'value' => function($model){
            $klasifikasiBaru = RefBidang::find()->where(['id_lama' => $model->id])->one();
            if($klasifikasiBaru) return $klasifikasiBaru->kd_urusan . "." . $klasifikasiBaru->kd_bidang . " " . $klasifikasiBaru->nm_bidang;
            return '';
        }
    ],
    'hapus',
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