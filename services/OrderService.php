<?php

namespace app\services;

use Yii;
use yii\base\Component;
use yii\web\NotFoundHttpException;
use app\models\ItemOrder;
use app\models\Order;
use app\traits\StatusMessage;

class OrderService extends Component
{
    use StatusMessage;

    /**
     * Создание заказа
     * @param \yii\web\Request
     * @return bool
     */
    public static function createOrder($request)
    {
        if (Yii::$app->user->isGuest) {
            self::showMessage('warning', 'Вы не авторизированы');
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();

        if ($request->isPost) {
            $order = new Order();
            $order->user_id = Yii::$app->user->id;

            if (!$order->save()) {
                $transaction->rollBack();

                self::showMessage('error', 'Проблема при сохранении заказа: ' . json_encode($order->getErrors()));
                return false;
            }

            $items = array_filter($request->post('item'));
            if (empty($items)) {
                $transaction->rollBack();

                self::showMessage('error', 'В заказе отсутствуют товары');
                return false;
            }

            foreach ($items as $itemId => $itemValue) {
                $itemOrder = new ItemOrder();
                $itemOrder->order_id = $order->id;
                $itemOrder->item_id = $itemId;
                $itemOrder->quantity = $itemValue;

                if (!$itemOrder->save()) {
                    $transaction->rollBack();

                    self::showMessage('error', 'Проблема при сохранении элментов заказа: ' . json_encode($itemOrder->getErrors()));
                    return false;
                }
            }

            $transaction->commit();
            self::showMessage('success', 'Заказ создан');
            return true;
        }

        self::showMessage('error', 'Неверный запрос');
        return false;
    }

    /**
     * Удаление заказа по ID
     * @param int $id ID
     * @return bool
     */
    public static function deleteOrder($id)
    {
        if (Yii::$app->user->isGuest) {
            self::showMessage('warning', 'Вы не авторизированы');
            return false;
        }

        $status = self::findOrder($id)->delete();

        if (!$status) {
            self::showMessage('error', "Проблема при удалении заказа");
            return false;
        }

        self::showMessage('warning', "Заказ № $id был удален");
        return true;
    }

    /**
     * Поиск заказа по ID
     * @param int $id ID
     * @return app\models\Order
     * @throws NotFoundHttpException if the model cannot be found
     */
    public static function findOrder($id)
    {
        if (($order = Order::findOne(['id' => $id])) !== null) {
            return $order;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
