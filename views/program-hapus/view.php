<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefProgramLama */
?>
<div class="ref-program-lama-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'kd_urusan',
            'kd_bidang',
            'kd_prog',
            'ket_program:ntext',
            'hapus',
        ],
    ]) ?>

</div>
