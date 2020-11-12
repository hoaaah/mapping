<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefRek4 */
?>
<div class="ref-rek4-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'kd_rek_1',
            'kd_rek_2',
            'kd_rek_3',
            'kd_rek_4',
            'nm_rek_4',
            'kd_ubah',
            'id_lama',
        ],
    ]) ?>

</div>
