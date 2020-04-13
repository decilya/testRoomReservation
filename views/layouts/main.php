<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\BootboxAsset;

AppAsset::register($this);
BootboxAsset::overrideSystemConfirm();
$this->title = Yii::$app->params['systemName'];
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode(Yii::$app->params['systemName']) ?></title>
        <?php $this->head() ?>

        <script>
            $(document).ready(function () {

                const myUserId = $("#userBlock").data('user');

                function sendStatus(myUserId) {
                    if (myUserId !== undefined && myUserId !== null && myUserId !== '') {

                        $.ajax({
                            method: 'POST',
                            dataType: 'json',
                            data: {userId: myUserId},
                            url: '/site/login-user-info',
                            success: function (data) {}
                        });
                    }
                }

                sendStatus(myUserId);

                setInterval(
                    function () {
                        sendStatus(myUserId);
                    },
                    15000
                );
            });
        </script>

    </head>
    <body>
    <?php $this->beginBody() ?>
    <div class="wrapper">
        <header class="header">
            <div class="container-static">

                <?php
                NavBar::begin([
                    'brandLabel' => Yii::$app->params['systemName'],
                    'brandUrl' => Yii::$app->homeUrl,
                    'options' => [
                        'class' => 'navbar-inverse navbar-fixed-top header-nav',
                    ],
                ]);
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav pull-right'],
                    'items' => [
                        (Yii::$app->user->identity->type == \app\models\User::TYPE_USER_ADMIN) ?
                            ['label' => 'Список забронированных номеров', 'url' => ['/admin/room/index']] : '',

                        (Yii::$app->user->identity->type == \app\models\User::TYPE_USER_ADMIN) ?
                            ['label' => 'Список номеров', 'url' => ['/admin/room/index']] : '',

                        (Yii::$app->user->identity->type == \app\models\User::TYPE_USER_ADMIN) ?
                            ['label' => 'Пользователи', 'url' => ['/admin/default/users']] : '',

                        Yii::$app->user->isGuest ? (
                        ['label' => 'Войти', 'url' => ['/site/login']]
                        ) : (
                            '<li>'
                            . Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(
                                'Выйти (' . Yii::$app->user->identity->username . ')',
                                [
                                    'class' => 'btn btn-link logout',
                                    'id' => 'userBlock',
                                    'data-user' => Yii::$app->user->identity->id,
                                    'data-name' => Yii::$app->user->identity->name,
                                    'data-type' => Yii::$app->user->identity->type,
                                    'data-surname' => Yii::$app->user->identity->surname,
                                    'data-patronymic' => Yii::$app->user->identity->patronymic,
                                ]
                            )
                            . Html::endForm()
                            . '</li>'
                        )
                    ],
                ]);
                NavBar::end();
                ?>
            </div>
        </header>

        <main class="main">
            <div class="container-content">
                <?= Breadcrumbs::widget([
                    'homeLink' => ['label' => 'Главная', 'url' => '/'],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </main>

        <footer class="footer">
            <div class="container">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <p class="pull-left footer__copyright">
                        &copy; 2020—<?= date('Y') ?>. Тестовое задание
                    </p>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <p class="pull-right footer__address">Система бронирования номеров</p>
                </div>
            </div>
        </footer>

    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>