<?php

namespace app\traits;

use Yii;

trait StatusMessage
{
    public static function showMessage($key = 'warning', $message = 'Проблема в обработке')
    {
        Yii::$app->session->setFlash($key, $message);
    }
}
