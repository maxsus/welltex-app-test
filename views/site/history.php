<?php

use yii\bootstrap4\Html;

function deleteOrderForm($orderId)
{
    return Html::beginForm(
        ['order/delete', 'id' => $orderId],
        'post',
        ['class' => 'd-flex align-items-center']
    )
        . Html::submitButton(
            'Удалить',
            ['class' => 'btn btn-sm btn-danger ms-2']
        )
        . Html::endForm();
}

?>

<div class="container my-5">
    <div class="row mb-5">
        <div class="col-md-8 offset-md-2">
            <h1>История заказов</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">

            <?php if (empty($orders)): ?>
                <p>Список заказов пуст</p>
            <?php endif ?>

            <?php foreach ($orders as $order): ?>
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Заказ № <?= $order->id ?> - <?= Yii::$app->formatter->asDateTime($order->created_at) ?></h5>
                        <?= deleteOrderForm($order->id) ?>
                    </div>

                    <div class="card-body">
                        <ul class="list-group">
                            <?php foreach ($order->itemOrders as $itemOrder): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><?= $itemOrder->item->name ?> - <?= $itemOrder->quantity ?> шт.</span>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>