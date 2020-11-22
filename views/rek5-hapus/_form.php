<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RefRek5Lama */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-rek5-lama-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kd_rek_1')->textInput() ?>

    <?= $form->field($model, 'kd_rek_2')->textInput() ?>

    <?= $form->field($model, 'kd_rek_3')->textInput() ?>

    <?= $form->field($model, 'kd_rek_4')->textInput() ?>

    <?= $form->field($model, 'kd_rek_5')->textInput() ?>

    <?= $form->field($model, 'nm_rek_5')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'peraturan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hapus')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
