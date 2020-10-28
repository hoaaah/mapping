<?php

use app\models\RefKegiatan;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RefKegiatanLamaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ref Kegiatan Lamas';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="ref-kegiatan-lama-index">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'pager' => [
                'firstPageLabel' => 'Awal',
                'lastPageLabel'  => 'Akhir'
            ],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'rowOptions' => function ($model, $key, $index, $grid) {
                $klasifikasiBaru = RefKegiatan::find()->where(['id_lama' => $model->id])->one();
                if($klasifikasiBaru) return ['class' => GridView::TYPE_DEFAULT];
                if(!$klasifikasiBaru){
                    $klasifikasiSama = RefKegiatan::find()->where(['ket_kegiatan' => $model->ket_kegiatan])->one();
                    if($klasifikasiSama){
                        if ($klasifikasiSama->kd_urusan == $model->kd_urusan && $klasifikasiSama->kd_bidang == $model->kd_bidang && $klasifikasiSama->kd_prog == $model->kd_prog && $klasifikasiSama->kd_keg == $model->kd_keg) return ['class' => GridView::TYPE_DEFAULT];
                    }
                }
                return ['class' => GridView::TYPE_WARNING]; // GridView::TYPE_DANGER 'kv-page-summary warning'
            },
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Create new Ref Kegiatan Lamas','class'=>'btn btn-default']).
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
                'heading' => '<i class="glyphicon glyphicon-list"></i> Ref Kegiatan Lamas listing',
                'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                'after'=>BulkButtonWidget::widget([
                            'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
                                ["bulk-delete"] ,
                                [
                                    "class"=>"btn btn-danger btn-xs",
                                    'role'=>'modal-remote-bulk',
                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                    'data-request-method'=>'post',
                                    'data-confirm-title'=>'Are you sure?',
                                    'data-confirm-message'=>'Are you sure want to delete this item'
                                ]),
                        ]).                        
                        '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
