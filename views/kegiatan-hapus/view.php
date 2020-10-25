<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefKegiatanLama */
?>
<div class="ref-kegiatan-lama-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'kd_urusan',
            'kd_bidang',
            'kd_prog',
            'kd_keg',
            'ket_kegiatan:ntext',
            'hapus',
        ],
    ]) ?>

</div>
