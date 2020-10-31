<?php

use app\models\JenisUbah;
use app\models\RefProgramLama;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RefProgramSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ref Programs';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="ref-program-index">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php $form = ActiveForm::begin(['id' => 'selection-gridview']); // 'action' => ['bulk-update'] 
    ?>
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel, 
            'pager' => [
                'firstPageLabel' => 'Awal',
                'lastPageLabel'  => 'Akhir'
            ],
            'pjax' => true,
            'columns' => require(__DIR__ . '/_columns.php'),
            'rowOptions' => function ($model, $key, $index, $grid) {
                $klasifikasiLama = RefProgramLama::find()->where("ket_program LIKE '%{$model->ket_program}%'")->one();
                if ($klasifikasiLama) {
                    if ($klasifikasiLama->kd_urusan == $model->kd_urusan && $klasifikasiLama->kd_bidang == $model->kd_bidang && $klasifikasiLama->kd_prog == $model->kd_prog) return ['class' => GridView::TYPE_DEFAULT];
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
                'heading' => '<i class="glyphicon glyphicon-list"></i> Ref Programs listing',
                'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                'after' =>

                '<div class="row"><div class="col-md-3">' .
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
                        'data' => ArrayHelper::map(RefProgramLama::find()->select(['id', "CONCAT(kd_urusan, '.', kd_bidang, '.', kd_prog, ' ', ket_program) AS ket_program"])->all(), 'id', 'ket_program'),
                        'options' => ['placeholder' => 'Pilih Program Lama ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        'pjaxContainerId' => 'crud-datatable-pjax',
                    ])->label(false) .
                    '</div><div class="col-md-3">' .
                    $form->field($searchModel, 'id_lama')->textInput(['placeholder' => 'Digit Terakhir'])->label(false) .
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
    'size' => 'modal-lg',
    "footer" => "", // always need it for jquery plugin
]) ?>
<?php Modal::end(); ?>