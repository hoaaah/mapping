<?php

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
        <?= $form->field($model, 'kd_urusan')->widget(Select2::class, [
            'options' => ['id' => 'cat-id'],
            'pluginOptions' => [
                'allowClear' => true,
                'placeholder' => 'Select...',
            ],
            'data' => ArrayHelper::map(RefUrusan::find()->all(), 'kd_urusan', 'nm_urusan')
        ]) ?>
    </div>

    <div class="col-md-3">
        <?= $form->field($model, 'kd_bidang')->widget(DepDrop::classname(), [
            'options' => ['id' => 'subcat-id'],
            'type' => DepDrop::TYPE_SELECT2,
            'pluginOptions' => [
                'depends' => ['cat-id'],
                'placeholder' => 'Select...',
                'url' => Url::to(['/site/bidang'])
            ]
        ]) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'ket_kegiatan')->textInput() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>