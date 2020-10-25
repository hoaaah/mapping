<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RefBidangLama */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-bidang-lama-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kd_urusan')->textInput() ?>

    <?= $form->field($model, 'kd_bidang')->textInput() ?>

    <?= $form->field($model, 'nm_bidang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kd_fungsi')->textInput() ?>

    <?= $form->field($model, 'hapus')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
