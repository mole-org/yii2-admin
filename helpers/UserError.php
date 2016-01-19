<?php
namespace app\helpers;

class UserError extends \yii\web\HttpException
{
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct(417, json_encode($message), $code, $previous);
    }
}