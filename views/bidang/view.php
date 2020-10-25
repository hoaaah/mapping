<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefBidang */
?>
<div class="ref-bidang-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'kd_urusan',
            'kd_bidang',
            'nm_bidang',
            'kd_fungsi',
            'kd_ubah',
            'id_lama',
        ],
    ]) ?>

</div>
