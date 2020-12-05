<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RefRek5Lama */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-rek5-lama-form">

<?= GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    // 'filterModel' => $searchModel,
    'pjax' => true,
    'columns' => [
        'kd_rek_1',
        'kd_rek_2',
        'kd_rek_3',
        'kd_rek_4',
        'kd_rek_5',
        'nm_rek_5',
        'ket'
    ],
    'toolbar' => [
        ['content' => '{toggleData}' .
            '{export}'],
    ],
    'striped' => true,
    'condensed' => true,
    'responsive' => true,
    'panel' => [
        'type' => 'primary',
        'heading' => '<i class="glyphicon glyphicon-list"></i> Kegiatan Diubah',
        'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
    ]
]) ?>
    
</div>
