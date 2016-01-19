<?php
namespace app\helpers\widgets;

class DetailView extends \yii\widgets\DetailView
{
    public $options = ['class' => 'table table-striped table-bordered'];
    public $template = '<tr><th>{label}</th><td>{value}</td></tr>';
}