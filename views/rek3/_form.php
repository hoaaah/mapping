<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RefRek3 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-rek3-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kd_rek_1')->textInput() ?>

    <?= $form->field($model, 'kd_rek_2')->textInput() ?>

    <?= $form->field($model, 'kd_rek_3')->textInput() ?>

    <?= $form->field($model, 'nm_rek_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'saldonorm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kd_ubah')->textInput() ?>

    <?= $form->field($model, 'id_lama')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
