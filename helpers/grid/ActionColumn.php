<?php
namespace app\helpers\grid;

use yii\helpers\Html;
use Yii;

class ActionColumn extends \yii\grid\ActionColumn
{
    public $headerOptions = ['class' => 'actions'];
    public $contentOptions = ['class' => 'actions'];

    /**
     * @inheritdoc
     */
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model) {
                return Html::a('<i class="fa fa-eye"></i>', $url, [
                    'title' => Yii::t('yii', 'View'),
                    'data-action' => 'get.modal',
                ]);
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model) {
                return Html::a('<i class="fa fa-pencil"></i>', $url, [
                    'title' => Yii::t('yii', 'Update'),
                    'data-action' => 'get.modal',
                ]);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model) {
                return Html::a('<i class="fa fa-trash"></i>', $url, [
                    'title' => Yii::t('yii', 'Delete'),
                    'data-action' => 'delete.grid-view',
                ]);
            };
        }
        if (!isset($this->buttons['password'])) {
            $this->buttons['password'] = function($url, $model) {
                return Html::a('<i class="fa fa-lock"></i>', $url, [
                    'title' => '修改密码',
                    'data-action' => 'get.modal'
                ]);
            };
        }
    }
}