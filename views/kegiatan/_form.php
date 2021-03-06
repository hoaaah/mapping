<?php

use app\models\JenisUbah;
use app\models\RefProgramLama;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RefProgram */
/* @var $form yii\widgets\ActiveForm */
$url = \yii\helpers\Url::to(['kegiatan-list']);
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
        // 'data' => ArrayHelper::map(RefKegiatanLama::find()->select(['id', "CONCAT(kd_urusan, '.', kd_bidang, '.', kd_prog, '.', kd_keg, ' ', ket_kegiatan) AS ket_kegiatan"])->all(), 'id', 'ket_kegiatan'),
        'options' => ['placeholder' => 'Pilih Kegiatan Lama ...'],
        // 'pluginOptions' => [
        //     'allowClear' => true
        // ],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'ajax' => [
                'url' => $url,
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(city) { return city.text; }'),
            'templateSelection' => new JsExpression('function (city) { return city.text; }'),
        ],
        'pjaxContainerId' => 'crud-datatable-pjax',
    ]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
