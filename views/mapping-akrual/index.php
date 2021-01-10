<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use kartik\growl\GrowlAsset;
use johnitvn\ajaxcrud\CrudAsset;

//  GrowlAsset will register to this view, so it will not load every ajax given.
GrowlAsset::register($this);
CrudAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel app\modules\parameter\models\RefAkrualRekSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mapping Rekening Akrual';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-akrual-rek-index">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'id' => 'ref-akrual-rek',
        'dataProvider' => $dataProvider,
        'responsive' => true,
        'hover' => true,
        'resizableColumns' => true,
        'panel' => ['type' => 'primary', 'heading' => $this->title],
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
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'label' => 'Rekening Permendagri 13',
                'attribute' => 'rek5TextWithCode'
            ],
            [
                'label' => 'Rekening Akrual',
                'attribute' => 'refAkrualRek.mappingAkrual.rek5TextWithCode'
            ],
            [
                'label' => 'Mapping 1',
                'attribute' => 'refAkrualRek.mapping1.rek5TextWithCode'
            ],
            [
                'label' => 'Mapping 2',
                'attribute' => 'refAkrualRek.mapping2.rek5TextWithCode'
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