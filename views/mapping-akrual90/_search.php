<?php

use app\models\RefBidang;
use app\models\RefUrusan;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RefBidangSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-bidang-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="col-md-3">
        <?= $form->field($model, 'kd_rek90_1')->textInput() ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'kd_rek90_2')->textInput() ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'kd_rek90_3')->textInput() ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'nm_rek90_6')->textInput() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>