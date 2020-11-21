<?php

use app\models\JenisUbah;
use app\models\RefRek4Lama;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RefRek4Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$url = \yii\helpers\Url::to(['rek4-list']);

$this->title = 'Ref Rek4s';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="ref-rek4-index">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php $form = ActiveForm::begin(['id' => 'selection-gridview']); // 'action' => ['bulk-update']  
    ?>
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,
            'pjax' => true,
            'columns' => require(__DIR__ . '/_columns.php'),
            'rowOptions' => function ($model, $key, $index, $grid) {
                $klasifikasiLama = RefRek4Lama::find()->where(['like', 'nm_rek_4', $model->nm_rek_4])->andWhere(['kd_rek_1' => $model->kd_rek_1])->one();
                if ($klasifikasiLama) {
                    if ($klasifikasiLama->kd_rek_1 == $model->kd_rek_1 && $klasifikasiLama->kd_rek_2 == $model->kd_rek_2 && $klasifikasiLama->kd_rek_3 == $model->kd_rek_3 && $klasifikasiLama->kd_rek_4 == $model->kd_rek_4) return ['class' => GridView::TYPE_DEFAULT];
                }
                return ['class' => GridView::TYPE_WARNING]; // GridView::TYPE_DANGER 'kv-page-summary warning'
            },
            'toolbar' => [
                ['content' =>
                Html::a(
                    '<i class="glyphicon glyphicon-repeat"></i>',
                    [''],
                    ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => 'Reset Grid']
                ) .
                    '{toggleData}' .
                    '{export}'],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Ref Rek4s listing',
                'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                'after' =>
                '<div class="row"><div class="col-md-2">' .
                    $form->field($searchModel, 'kd_ubah')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(JenisUbah::find()->all(), 'id', 'jenis'),
                        'options' => ['placeholder' => 'Pilih Jenis Ubah ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        'pjaxContainerId' => 'crud-datatable-pjax',
                    ])->label(false) .
                    '</div><div class="col-md-4">' .
                    $form->field($searchModel, 'id_lama')->widget(Select2::classname(), [
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
                    ])->label(false) .
                    '</div><div class="col-md-2">' .
                    $form->field($searchModel, 'kd_ujung')->widget(MaskedInput::class, [
                        'options' => ['placeholder' => '2 Digit Terakhir'],
                        'mask' => '9[9].9[9]'
                    ])->label(false) .
                    '</div><div class="col-md-2">' .
                    $form->field($searchModel, 'tambah_sisip')->textInput(['placeholder' => $searchModel->getAttributeLabel('tambah_sisip')])->label(false) .
                    '</div><div class="col-md-2">' .
                    Html::submitButton('<i class="glyphicon glyphicon-arrow-right"></i> Submit Perubahan', ['id' => 'batch-submit', 'class' => 'btn btn-warning', 'data-confirm' => "Akan menyimpan data dana transfer pada belanja tersebut, pastikan data sudah benar.",]) .
                    '</div></div>',
            ]
        ]) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "", // always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>