<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RefBidang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-bidang-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kd_urusan')->textInput() ?>

    <?= $form->field($model, 'kd_bidang')->textInput() ?>

    <?= $form->field($model, 'nm_bidang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kd_fungsi')->textInput() ?>

    <?= $form->field($model, 'kd_ubah')->textInput() ?>

    <?= $form->field($model, 'id_lama')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
