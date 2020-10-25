<?php

use app\models\JenisUbah;
use app\models\RefBidangLama;
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
/* @var $searchModel app\models\RefBidangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ref Bidangs';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="ref-bidang-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php $form = ActiveForm::begin(['id' => 'selection-gridview']); // 'action' => ['bulk-update'] ?>
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Ref Bidangs listing',
                'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                'after'=> 
                
                '<div class="row"><div class="col-md-3">'.
                $form->field($searchModel, 'kd_ubah')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(JenisUbah::find()->all(), 'id', 'jenis'),
                    'options' => ['placeholder' => 'Pilih Jenis Ubah ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'pjaxContainerId' => 'crud-datatable-pjax',
                ])->label(false).
                '</div><div class="col-md-3">'.
                $form->field($searchModel, 'id_lama')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(RefBidangLama::find()->select(['id', "CONCAT(kd_urusan, '.', kd_bidang, ' ', nm_bidang) AS nm_bidang"])->all(), 'id', 'nm_bidang'),
                    'options' => ['placeholder' => 'Pilih Bidang Lama ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'pjaxContainerId' => 'crud-datatable-pjax',
                ])->label(false).
                '</div><div class="col-md-3">'.
                Html::submitButton( '<i class="glyphicon glyphicon-arrow-right"></i> Submit Perubahan', ['id' => 'batch-submit', 'class' => 'btn btn-warning', 'data-confirm' => "Akan menyimpan data dana transfer pada belanja tersebut, pastikan data sudah benar.",]).
                '</div></div>',
                // .
                // BulkButtonWidget::widget([
                //             'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
                //                 ["bulk-delete"] ,
                //                 [
                //                     "class"=>"btn btn-danger btn-xs",
                //                     'role'=>'modal-remote-bulk',
                //                     'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                //                     'data-request-method'=>'post',
                //                     'data-confirm-title'=>'Are you sure?',
                //                     'data-confirm-message'=>'Are you sure want to delete this item'
                //                 ]),
                //         ]).                        
                //         '<div class="clearfix"></div>',
            ]
        ])?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
