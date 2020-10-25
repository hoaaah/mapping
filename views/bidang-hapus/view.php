<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefBidangLama */
?>
<div class="ref-bidang-lama-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'kd_urusan',
            'kd_bidang',
            'nm_bidang',
            'kd_fungsi',
            'hapus',
        ],
    ]) ?>

</div>
