<?php
namespace app\helpers\grid;

class CheckboxColumn extends \yii\grid\CheckboxColumn
{
    public $headerOptions = ['class' => 'text-center'];
    public $contentOptions = ['class' => 'text-center pk'];
}