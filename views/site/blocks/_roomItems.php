<?php

use kartik\date\DatePicker;

/**
 * @var  \app\models\Rooms[] $r
 * @var  string $userId ;*
 */
$count = 0;
foreach ($rooms as $room) {
    $count++;
    ?>
    <article class="orderItem container marginTop20" data-id="<?= $room->id; ?>">
        <?php if (empty($room->getRelatedRecords()['bookedRooms'])) { ?>
            <?= $this->render('_roomItem', [
                'room' => $room,
            ]); ?>
        <?php } ?>
    </article>
<?php } ?>

