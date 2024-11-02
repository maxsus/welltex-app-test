<?php

use yii\bootstrap4\Html;

?>

<div id="app" class="container my-5">
    <div class="row mb-5">
        <div class="col-md-8 offset-md-2">
            <h1>Создать заказ</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <?= Html::beginForm(['order/create'], 'post', ['class' => 'card']) ?>

            <div class="card-header">
                <h5>Список товаров</h5>
            </div>

            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($items as $item): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="form-check d-flex align-items-center">
                                <span><?= $item->name ?></span>
                            </div>
                            <div>
                                <?php if (!Yii::$app->user->isGuest) : ?>
                                    <input class="form-control" type="number" min="0"
                                        name="item[<?= $item->id ?>]" value="0">
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="card-footer text-end">
                <?php if (Yii::$app->user->isGuest): ?>
                    <?= Html::a('Войдите для оформления заказа', 'login') ?>
                <?php endif ?>
                <?php if (!Yii::$app->user->isGuest): ?>
                    <?= Html::submitButton('Оформить заказ', ['class' => 'btn btn-success']); ?>
                <?php endif ?>
            </div>

            <?= Html::endForm() ?>
        </div>
    </div>
</div>