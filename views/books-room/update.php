<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BookedRooms */

$this->title = 'Update Booked Rooms: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Booked Rooms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="booked-rooms-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>