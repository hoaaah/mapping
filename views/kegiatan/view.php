<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefKegiatan */
?>
<div class="ref-kegiatan-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'kd_urusan',
            'kd_bidang',
            'kd_prog',
            'kd_keg',
            'ket_kegiatan:ntext',
            'kd_ubah',
            'id_lama',
        ],
    ]) ?>

</div>
