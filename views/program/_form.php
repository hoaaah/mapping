<?php

use app\models\JenisUbah;
use app\models\RefProgramLama;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RefProgram */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-program-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kd_ubah')->widget(Select2::class, [
        'data' => ArrayHelper::map(JenisUbah::find()->all(), 'id', 'jenis'),
        'options' => ['placeholder' => 'Pilih Jenis Ubah ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, 'id_lama')->widget(Select2::class, [
        'data' => ArrayHelper::map(RefProgramLama::find()->select(['id', "CONCAT(kd_urusan, '.', kd_bidang, '.', kd_prog, ' ', ket_program) AS ket_program"])->all(), 'id', 'ket_program'),
        'options' => ['placeholder' => 'Pilih Program Lama ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
