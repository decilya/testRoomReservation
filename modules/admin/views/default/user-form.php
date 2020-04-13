<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;

/**
 * @var $user User
 */
?>

<div class="createUser">
<?php
    $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
        'options' => [
            'name' => 'managerForm',
            'class' => 'mdl-grid'
        ],
        'id' => 'managerForm']);
?>  
    <div class='mdl-cell mdl-cell--1-col'></div>
    <div class='mdl-cell mdl-cell--10-col'>

        <?= ($user->isNewRecord) ? '<h3>Создание пользователя</h3>' : '<h3>Редактирование пользователя ' . $user->username. '</h3>'; ?>

    </div>
    <div class='mdl-cell mdl-cell--1-col'></div>
    <div class='mdl-cell mdl-cell--1-col'></div>
    <div class='mdl-cell mdl-cell--10-col'>
        <div id="blockNewUser">
        
            <?php if ($user->type !== User::TYPE_USER_ADMIN) { ?>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <select class="mdl-textfield__input" name="typeUser" id="typeUser" required="">
                            <option <?php if ($user->type == User::TYPE_USER_MANAGER) {
                                echo "selected";
                            } ?> selected value="<?= User::TYPE_USER_MANAGER ?>">Менеджер
                            </option>
                            <option <?php if ($user->type == User::TYPE_USER_MASTER) {
                                echo "selected";
                            } ?> value="<?= User::TYPE_USER_MASTER ?>">Ведущий
                            </option>
                            <option <?php if (($user->type == User::TYPE_USER_STUDENT) || ($user->isNewRecord)) {
                                echo "selected";
                            } ?> value="<?= User::TYPE_USER_STUDENT ?>">Слушатель
                            </option>

                            <?php if ((Yii::$app->user->identity->type == User::TYPE_USER_MANAGER) ||
                                (Yii::$app->user->identity->type == User::TYPE_USER_ADMIN)) { ?>
                                <option <?php if ($user->type == User::TYPE_USER_ADMIN) {
                                    echo "selected";
                                } ?> value="<?= User::TYPE_USER_ADMIN ?>">Администратор
                                </option>
                            <?php } ?>
                            

                        </select>
                        <label for="typeUser" class="mdl-textfield__label" >Тип учетной записи:</label>
                    </div>
            <?php } ?>
            <?php if ($user->type !== User::TYPE_USER_ADMIN) { ?>
                <?= $form->field($user, 'email', [
                    'template' => '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">{input}{label}{error}</div>',
                    'labelOptions' => [ 'class' => 'mdl-textfield__label'] 
                    ])->textInput(['maxlength' => true, 'class' => 'mdl-textfield__input']); ?>
                <?= $form->field($user, 'surname', [
                    'template' => '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">{input}{label}{error}</div>',
                    'labelOptions' => [ 'class' => 'mdl-textfield__label'] 
                    ])->textInput(['maxlength' => true, 'class' => 'mdl-textfield__input']); ?>
                <?= $form->field($user, 'name', [
                    'template' => '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">{input}{label}{error}</div>',
                    'labelOptions' => [ 'class' => 'mdl-textfield__label'] 
                    ])->textInput(['maxlength' => true, 'class' => 'mdl-textfield__input']); ?>
                <?= $form->field($user, 'patronymic', [
                    'template' => '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">{input}{label}{error}</div>',
                    'labelOptions' => [ 'class' => 'mdl-textfield__label'] 
                    ])->textInput(['maxlength' => true, 'class' => 'mdl-textfield__input']); ?>
                <?= $form->field($user, 'phone', [
                    'template' => '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">{input}{label}{error}</div>',
                    'labelOptions' => [ 'class' => 'mdl-textfield__label'] 
                    ])->textInput(['maxlength' => true, 'class' => 'mdl-textfield__input']); ?>
            <?php } ?>
            <?php if (($user->type !== User::TYPE_USER_ADMIN) ||
                (($user->type === User::TYPE_USER_ADMIN) && ($user->username === Yii::$app->user->identity->username))) { ?>
                <?= $form->field($user, 'record_time_min', [
                    'template' => '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">{input}{label}</div>',
                    'labelOptions' => [ 'class' => 'mdl-textfield__label hidden'] 
                    ])->textInput(['maxlength' => true, 'class' => 'mdl-textfield__input hidden']) ?> 
            <?php } else { ?>
                <div class="alert alert-info myAlert" role="alert">
                    <p>
                        Только непосредственно сам пользователь-администратор может изменять время по умолчанию для своих
                        трансляций! Для редактирования зайдите под учетной записью
                        <strong><a href="/site/logout"><?= $user->username; ?></a></strong>.
                    </p>
                </div>
            <?php } ?>

        </div>
    </div>
    <div class='mdl-cell mdl-cell--1-col'></div>
    <div class='mdl-cell mdl-cell--1-col'></div>
    <div class="mdl-cell mdl-cell--11-col">
        <div class="col-sm-6 col-lg-6 col-md-6">
            <?php if (!$user->isNewRecord) { ?>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <a href="/admin/default/update-user-pass?id=<?= $user->id ?>" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Отправить новый
                        пароль</a>
                </div>
            <?php } ?>
        </div>
        <div class="col-sm-6 col-lg-6 col-md-6">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <?= Html::submitButton($user->isNewRecord ? 'Создать' : 'Обновить', ['class' => $user->isNewRecord ? 'mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent' : 'mdl-button mdl-js-button mdl-button--raised mdl-button--accent']) ?>
            </div>
        </div>

    </div>
    
    <?php ActiveForm::end(); ?>
</div>