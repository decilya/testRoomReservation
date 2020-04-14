<?php

use kartik\date\DatePicker;

$this->registerJsFile('@web/js/bookNowController.js', ['depends' => 'yii\web\JqueryAsset']);
/**
 * @var  \app\models\Rooms[] $rooms
 * @var  string $userId ;*
 */
foreach ($rooms as $room) {
    ?>
    <article class="orderItem container marginTop20" data-id="<?= $room->id; ?>">
<!--        --><?php //if (empty($room->getRelatedRecords()['bookedRooms'])) { ?>
            <?= $this->render('_roomItem', [
                'room' => $room,
            ]); ?>
<!--        --><?php //} ?>
    </article>
<?php } ?>

<?php
if (empty($rooms)) { ?>
    <article class="orderItem container marginTop20">
        <p>Нет номеров в системе!</p>
    </article>
<?php } ?>

