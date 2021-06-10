<?php

use hoaaah\sbadmin2\widgets\Card;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\tabs\TabsX;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\parameter\RefAkrualRek */
/* @var $form yii\widgets\ActiveForm */

if (!$model->isNewRecord) {
    $model->rekening90 = $model->refRek5->rek5Code;
}
?>

<div class="ref-akrual-rek-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?= TabsX::widget([
        'items' => [
            [
                'label' => 'Rekening Permendagri 64',
                'content' => DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'label' => 'Rekening Permendagri 64',
                            'value' => function ($model) {
                                return $model->mappingAkrual->rek5TextWithCode;
                            }
                        ]
                    ],
                ])
            ],
        ],
        'position' => TabsX::POS_ABOVE,
        'bordered' => true,
        'encodeLabels' => false
    ])    ?>

    <div class="row">

        <div class="col-md-12">
            <?= TabsX::widget([
                'items' => [
                    [
                        'label' => 'Rekening 90',
                        'content' => $form->field($model, 'rekening90')->widget(Select2::class, [
                            'data' => $refAkrualList,
                            'options' => ['placeholder' => 'Rekening 90 ...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                // 'minimumInputLength' => 3,
                                // 'language' => [
                                //     'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                // ],
                                // 'ajax' => [
                                //     'url' => Url::to(['rekening-akrual']),
                                //     'dataType' => 'json',
                                //     'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                // ],
                                // 'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                // 'templateResult' => new JsExpression('function(city) { return city.text; }'),
                                // 'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                            ],
                        ])
                    ],
                ],
                'position' => TabsX::POS_ABOVE,
                'bordered' => true,
                'encodeLabels' => false
            ]) ?>
        </div>
    </div>

    <?= $form->field($model, 'dirinci')->widget(SwitchInput::class, []) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fas fa-plus"></i>  Simpan', ['id' => 'submit-button', 'class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJs(
    <<<JS
$('form#{$model->formName()}').on('beforeSubmit',function(e)
{
    $("#submit-button").attr("disabled", "disabled");
    $("#submit-button").html('<i class="fas fa-circle-notch fa-spin"></i> Simpan');
    
    var \$form = $(this);
    $.post(
        \$form.attr("action"), //serialize Yii2 form 
        \$form.serialize()
    )
        .done(function(result){
            if(result == 1)
            {
                $("#ajaxCrudModal").modal('hide'); //hide modal after submit
                $.pjax.reload({container:'#ref-akrual-rek-pjax'});
            }else
            {
                $("#submit-button").removeAttr("disabled");
                $("#submit-button").html('<i class="fas fa-plus"></i> Simpan');
                $.notify({message: result}, {type: 'danger', z_index: 10031})
            }
        }).fail(function(){
            $("#submit-button").removeAttr("disabled");
            $("#submit-button").html('<i class="fas fa-plus"></i> Simpan');
            $.notify({message: "Server Error, refresh and try again."}, {type: 'danger', z_index: 10031})
        });
    return false;
});

JS
);
?>