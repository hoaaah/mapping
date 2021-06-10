<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\parameter\RefAkrualRek */

$this->title = 'Create Ref Akrual Rek';
$this->params['breadcrumbs'][] = ['label' => 'Ref Akrual Reks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-akrual-rek-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
