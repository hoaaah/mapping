<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefRek3 */
?>
<div class="ref-rek3-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'kd_rek_1',
            'kd_rek_2',
            'kd_rek_3',
            'nm_rek_3',
            'saldonorm',
            'kd_ubah',
            'id_lama',
        ],
    ]) ?>

</div>
