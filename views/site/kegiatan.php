<?php

use kartik\widgets\FileInput;
use yii\bootstrap\Modal;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = 'Cek Kegiatan';
?>
<div class="cek-kegiatan">
    <?php $form = ActiveForm::begin([
        'id' => $model->formName(),
        'options'=>[
            'enctype'=>'multipart/form-data',
            'onSubmit' => "return false"
        ],
    ]); ?>

    <?= $form->field($model, 'image')->widget(FileInput::class, [
        'options' => ['multiple' => false, 'accept' => 'office/*'],
        'pluginOptions' => [
            'showUpload' => false,
            'previewFileType' => 'office',
            'removeClass' => 'btn btn-danger',
            'showCaption' => false,
            // 'uploadUrl' => Url::to(['/site/file-upload']),
            // 'uploadExtraData' => [
            //     'album_id' => 20,
            //     'cat_id' => 'Nature'
            // ],
            // 'maxFileCount' => 10
        ]
    ])->label(false) ?>

    <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
    ]) ?>

    <div class="form-group">
        <p class="text-info small">Silakan drag & drop file csv dari ref_kegiatan/ref_rekening dengan format yang telah diberikan kemudian tekan unggah. Tunggu hingga proses selesai dan muncul popup berisi tabel tambahan kegiatan di database. Proses memunculkan data pada popup mungkin memakan waktu.
        </p>
        <div class="form-group">
            <?= Html::a('<i class="fa fa-upload"></i> Process', false, ['class' => 'btn btn-success', 'id' => 'submitButton'] ) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php

Modal::begin([
    'id' => 'importingModal',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
    'options' => [
        'tabindex' => false // important for Select2 to work properly
    ], 
    'size' => 'modal-lg'
]);
 
echo '...';
 
Modal::end();
$this->registerJs(<<<JS
    $("#submitButton").on("click", function(e){
        $("#submitButton").addClass('disabled');
        $("#submitButton").html('<i class="fa fa-spinner fa-spin"></i> Process')
        var form = $('form#{$model->formName()}');
        var formData = new FormData(form.get(0));
        var formURL = form.attr("action");
        $.ajax(
        {
            url : formURL,
            type: "POST",
            data : formData,
            contentType: false,
            processData: false,
            cache: false,
            success:function(data) // , textStatus, jqXHR 
            {
                console.log(data)
                
                $('#importingModal').modal();
                var modal = $('#importingModal')
                var title = 'Importing Data' 
                var href = data.redirect
                modal.find('.modal-title').html(title)
                modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
                $.post(href)
                .done(function( data ) {
                    modal.find('.modal-body').html(data)
                });
                return false;
            },
            error: function() 
            {
                console.log("gagal");      
            }
        });        
    })
JS
);
?>