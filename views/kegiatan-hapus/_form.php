<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RefKegiatanLama */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-kegiatan-lama-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kd_urusan')->textInput() ?>

    <?= $form->field($model, 'kd_bidang')->textInput() ?>

    <?= $form->field($model, 'kd_prog')->textInput() ?>

    <?= $form->field($model, 'kd_keg')->textInput() ?>

    <?= $form->field($model, 'ket_kegiatan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'hapus')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
