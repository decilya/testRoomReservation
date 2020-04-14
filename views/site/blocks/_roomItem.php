<?php

use kartik\date\DatePicker;
use app\assets\MaskAsset;

/**
 * @var  \app\models\Rooms $room ;
 * @var int $userId
 */
?>

<div class="row">
    <div class="col-lg-1 col-md-1 col-sm-1">
        <div class="roomId">
            №<?= $room->id; ?> - <?= $room->id; ?>
        </div>
    </div>

    <div class="col-lg-2 col-md-2 col-sm-2"  title="<?= $room->description; ?>">
        <div class="roomTitle">
            <?= $room->name; ?>
        </div>
    </div>

    <?php
    $form = \yii\widgets\ActiveForm::begin([
        'enableAjaxValidation' => true,
        'options' => [
            'name' => 'day_' . $room->id,
            'id' => 'day_' . $room->id,
        ]
    ]);
    ?>

    <div class="col-lg-2 col-md-2 col-sm-2">
        <div class="roomUserName">
            <?= $form->field(new \app\models\BookedRooms(), 'user_name')->textInput(['id'=>'user_name' . $room->id]); ?>
        </div>
    </div>

    <div class="col-lg-2 col-md-2 col-sm-2">
        <div class="roomPhone">
            <?= $form->field(new \app\models\BookedRooms(), 'phone')->textInput(['id'=>'phone' . $room->id, 'class' => 'mask']); ?>
        </div>
    </div>

    <div class="col-lg-2 col-md-2 col-sm-2">
        <label> Дата бронирования
            <?= DatePicker::widget([
                'name' => 'datetime' . $room->id,
                'id' => 'day' . $room->id,
                'options' => [
                    'placeholder' => 'Select operating time ...',
                ],
                'convertFormat' => true,
                'pluginOptions' => [
                    'format' => 'yyyy-MM-dd'
                ]
            ]); ?>
        </label>
    </div>

    <div class="col-lg-1 col-md-1 col-sm-1">
        <?= $form->field(new \app\models\BookedRooms(), 'day_calc')->textInput(['type' => 'number', 'id'=>'day_calc' . $room->id]); ?>
    </div>

    <?php \yii\widgets\ActiveForm::end(); ?>

    <div class="col-lg-2 col-md-2 col-sm-2">
        <div class="roomBtn">
            <a class="bookNow btn btn-success" data-room="<?= $room->id; ?>">Забронировать</a>
        </div>
    </div>
</div>
<hr/>