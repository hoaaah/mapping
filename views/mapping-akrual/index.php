<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use kartik\growl\GrowlAsset;
use johnitvn\ajaxcrud\CrudAsset;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;

//  GrowlAsset will register to this view, so it will not load every ajax given.
GrowlAsset::register($this);
CrudAsset::register($this);

$url = \yii\helpers\Url::to(['rek-akrual-list']);

/* @var $this yii\web\View */
/* @var $searchModel app\modules\parameter\models\RefAkrualRekSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mapping Rekening Akrual';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-akrual-rek-index">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php $form = ActiveForm::begin(['id' => 'selection-gridview']); // 'action' => ['bulk-update'] 
    ?>

    <?= GridView::widget([
        'id' => 'ref-akrual-rek',
        'dataProvider' => $dataProvider,
        'responsive' => true,
        'hover' => true,
        'resizableColumns' => true,
        'panel' => [
            'type' => 'primary',
            'heading' => $this->title,
            'after' =>

            '<div class="row"><div class="col-md-6">' .
                $form->field($searchModel, 'kode_akrual')->widget(Select2::classname(), [
                    // 'data' => ArrayHelper::map(RefKegiatanLama::find()->select(['id', "CONCAT(kd_urusan, '.', kd_bidang, '.', kd_prog, '.', kd_keg, ' ', ket_kegiatan) AS ket_kegiatan"])->all(), 'id', 'ket_kegiatan'),
                    'options' => ['placeholder' => 'Pilih Rekening Akrual ...'],
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
                    'pjaxContainerId' => 'ref-akrual-rek-pjax',
                ])->label(false) .
                '</div><div class="col-md-4">' .
                // $form->field($searchModel, 'id_lama')->widget(Select2::classname(), [
                //     'data' => ArrayHelper::map(RefProgramLama::find()->select(['id', "CONCAT(kd_urusan, '.', kd_bidang, '.', kd_prog, ' ', ket_program) AS ket_program"])->all(), 'id', 'ket_program'),
                //     'options' => ['placeholder' => 'Pilih Program Lama ...'],
                //     'pluginOptions' => [
                //         'allowClear' => true
                //     ],
                //     'pjaxContainerId' => 'crud-datatable-pjax',
                // ])->label(false) .
                // '</div><div class="col-md-3">' .
                // $form->field($searchModel, 'kd_ujung')->textInput(['placeholder' => 'Digit Terakhir'])->label(false) .
                // '</div><div class="col-md-2">' .
                Html::submitButton('<i class="glyphicon glyphicon-arrow-right"></i> Kirim Data', ['id' => 'batch-submit', 'class' => 'btn btn-warning', 'data-confirm' => "Akan menyimpan data dana transfer pada belanja tersebut, pastikan data sudah benar.",]) .
                '</div></div>',
        ],
        'responsiveWrap' => false,
        'toolbar' => [
            [
                'content' => '{export}{toggleData}',
            ],
        ],
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'pjax' => true,
        'pjaxSettings' => [
            'options' => ['id' => 'ref-akrual-rek-pjax', 'timeout' => 5000],
        ],
        // 'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'kartik\grid\CheckboxColumn',
                'width' => '20px',
            ],
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'label' => 'Rekening Permendagri 90',
                'attribute' => 'rek5TextWithCode'
            ],
            [
                'label' => 'Rekening Akrual',
                'attribute' => 'refAkrualRek.mappingAkrual.rek5TextWithCode'
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update} {delete}',
                'noWrap' => true,
                'vAlign' => 'top',
                'visibleButtons' => [
                    'delete' => function ($model) {
                        if (!$model->refAkrualRek) return false;
                        return true;
                    }
                ],
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<span class="fas fa-edit"></span>',
                            $url,
                            [
                                'role' => 'modal-remote',
                                'title' => "Mapping",
                                // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                // 'data-method' => 'POST',
                                // 'data-pjax' => 1
                            ]
                        );
                    },
                    'view' => function ($url, $model) {
                        return Html::a(
                            '<span class="fas fa-eye"></span>',
                            $url,
                            [
                                'role' => 'modal-remote',
                                'title' => "Lihat",
                            ]
                        );
                    },
                ]
            ],
        ],
    ]); ?>
    <?php ActiveForm::end(); ?>
</div>
<?php Modal::begin([
    'id' => 'ajaxCrudModal',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
    'options' => [
        'tabindex' => false // important for Select2 to work properly
    ],
    'size' => 'modal-lg',
]);

echo '...';

Modal::end();
?>