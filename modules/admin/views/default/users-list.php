<?php

/**
 * @var \app\models\User $data
 * @var \yii\debug\models\timeline\DataProvider $dataProvider
 */

use yii\widgets\LinkPager;
use yii\grid\GridView;

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

$items = (!empty($dataProvider)) ? $dataProvider->getModels() : null;

?>
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--1-col"></div>
        <div class="mdl-cell mdl-cell--10-col">
            <?= $this->title; ?>

            <div class="blog-header">
                <a href="<?= \yii\helpers\Url::to(['/admin/default/create-user']) ?>"
                   class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Создать</a>
            </div>
        </div>
        <div class="mdl-cell mdl-cell--1-col"></div>
    </div>
<?php if (!empty($items)) { ?>
    <div class="mdl-grid">

        <div class="mdl-cell mdl-cell--1-col"></div>
        <?php
        $tableProvider = Clone $dataProvider;
        $tableProvider->pagination = false;
        echo GridView::widget([
            'dataProvider' => $tableProvider,
            'id' => 'ordersTbl',
            'options' => [
                'class' => 'mdl-cell mdl-cell--10-col'
            ],
            'tableOptions' => [
                'class' => 'mdl-data-table mdl-js-data-table mdl-shadow--2dp'
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'username',
                'email',
                'phone',
                [
                    'attribute' => 'created_at',
                    'label' => 'Дата создания',
                    'content' => function ($data) {
                        return date('d.m.Y H:i', $data->created_at);
                    },
                ],
                [
                    'attribute' => 'created_at',
                    'label' => 'Дата редактирования',
                    'content' => function ($data) {
                        return date('d.m.Y H:i', $data->updated_at);
                    },
                ],

                [
                    'attribute' => 'type',
                    'label' => 'Тип учетной записи',
                    'content' => function ($data) {
                        /**  @var \app\models\User $data */
                        return $data->getUserTypeByString($data);
                    },
                ],
                [
                    'label' => 'Действие',
                    'content' => function ($data) {

                        /** @var \app\models\User $data */
                        if ($data->status_id == \app\models\User::STATUS_ACTIVE) {
                            if ($data->type !== \app\models\User::TYPE_USER_ADMIN) {
                                return "<a href='/admin/default/update-user/?id=$data->id' class='editUser'><i class='material-icons'>edit</i></a>
                                            <a href='/admin/default/delete-user/?id=$data->id' 
                                            class='detachUser' data-confirm='Вы уверены?'><i class='material-icons'>delete_forever</i></a>";
                            }
                        }

                        return false;

                    },
                ],
            ],
            'emptyText' => 'Здесь будут отображаться все активные пользователи зарегесированные в системе',
            'summary' => "",
        ]);
        ?>
        <div class="mdl-cell mdl-cell--1-col"></div>
        <div class="mdl-cell mdl-cell--1-col"></div>
        <div class="paginator-material mdl-cell mdl-cell--10-col">
            <?=
            LinkPager::widget([
                'options' => [
                    'class' => 'mdl-list'
                ],
                'pageCssClass' => ['class' => 'mdl-list__item'],
                'nextPageLabel' => false,//наличие порядкового переключателя вперед
                'prevPageLabel' => false,//наличие порядкового переключателя назад
                'linkOptions' => ['class' => 'mdl-button mdl-js-button mdl-js-ripple-effect'],
                'pagination' => $dataProvider->pagination,
                'lastPageLabel' => true,
                'firstPageLabel' => true
            ]);
            ?>
        </div>
        <div class="mdl-cell mdl-cell--1-col"></div>
    </div>
<?php } ?>