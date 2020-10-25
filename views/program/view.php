<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefProgram */
?>
<div class="ref-program-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'kd_urusan',
            'kd_bidang',
            'kd_prog',
            'ket_program:ntext',
            'kd_ubah',
            'id_lama',
        ],
    ]) ?>

</div>
