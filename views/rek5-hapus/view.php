<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefRek5Lama */
?>
<div class="ref-rek5-lama-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'kd_rek_1',
            'kd_rek_2',
            'kd_rek_3',
            'kd_rek_4',
            'kd_rek_5',
            'nm_rek_5',
            'peraturan',
            'hapus',
        ],
    ]) ?>

</div>
