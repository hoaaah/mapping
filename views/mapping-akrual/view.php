<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\parameter\RefAkrualRek */

$this->title = $model->kd_rek_1;
$this->params['breadcrumbs'][] = ['label' => 'Ref Akrual Reks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-akrual-rek-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'kd_rek_1',
            'kd_rek_2',
            'kd_rek_3',
            'kd_rek_4',
            'kd_rek_5',
            'kd_akrual_1',
            'kd_akrual_2',
            'kd_akrual_3',
            'kd_akrual_4',
            'kd_akrual_5',
            'kd_akruald_1',
            'kd_akruald_2',
            'kd_akruald_3',
            'kd_akruald_4',
            'kd_akruald_5',
            'kd_akrualk_1',
            'kd_akrualk_2',
            'kd_akrualk_3',
            'kd_akrualk_4',
            'kd_akrualk_5',
        ],
    ]) ?>

</div>
