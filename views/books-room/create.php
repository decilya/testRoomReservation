<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BookedRooms */

$this->title = 'Create Booked Rooms';
$this->params['breadcrumbs'][] = ['label' => 'Booked Rooms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="booked-rooms-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>