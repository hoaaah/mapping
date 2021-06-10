<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\parameter\RefAkrualRek */

$this->title = 'Update Ref Akrual Rek: ' . $model->kd_rek_1;
$this->params['breadcrumbs'][] = ['label' => 'Ref Akrual Reks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kd_rek_1, 'url' => ['view', 'kd_rek_1' => $model->kd_rek_1, 'kd_rek_2' => $model->kd_rek_2, 'kd_rek_3' => $model->kd_rek_3, 'kd_rek_4' => $model->kd_rek_4, 'kd_rek_5' => $model->kd_rek_5]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ref-akrual-rek-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
