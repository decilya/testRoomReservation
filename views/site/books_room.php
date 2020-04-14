<?php
/**
 * @var \app\models\Rooms[] $rooms
 */
?>
<section id="booksRoom">
    <main id="customerCabinet" class="container" style="min-height: 280px; position: relative">
        <div id="infoBlock">
            <div id="roomSuccess" class="alert alert-success" hidden>
                Вы успешно забронировали комнату <span id="roomIdSuccess"></span>!
            </div>
        </div>
        <section id="currentOrders" class="row">
            <div id="orderItems">
                <?= $this->render('blocks/_roomItems', [
                    'rooms' => $rooms
                ]); ?>
            </div>
        </section>
    </main>
</section>