<?php
namespace app\helpers\grid;

use Closure;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class GridView extends \yii\grid\GridView 
{
    public $layout = '<div class="grid-heading"><div class="grid-summary">{summary}</div>{toolbar}</div>{items}{pager}';

    public $actions = [];

    public $moreActions = [];

    public $moreActionsTemplate = '';
    /**
     * @var string
     */
    public $actionsTemplate = '{create} {multi-delete}';

    /**
     * @var callable a callback that creates a button URL using the specified model information.
     * The signature of the callback should be the same as that of [[createUrl()]].
     * If this property is not set, button URLs will be created using [[createUrl()]].
     */
    public $urlCreator;

    public $controller;

    /**
     * @inheritdoc
     */
    public function renderSection($name)
    {
        switch ($name) {
            case "{toolbar}":
                return $this->renderToolbar();
            default:
                return parent::renderSection($name);
        }
    }

    public function renderToolbar()
    {
        $this->initDefaultActions();
        $tpl = preg_replace_callback('/\\{([\w\-\/]+)\\}/', function($matches) {
            $name = $matches[1];
            if (isset($this->actions[$name])) {
                $url = $this->createUrl($name);

                return call_user_func($this->actions[$name], $url);
            } else {
                return '';
            }
        }, $this->actionsTemplate);
        return Html::tag('div', $tpl . $this->renderMore(), ['class' => 'grid-toolbar btn-group']);
    }

    public function renderMore()
    {
        if ($this->moreActionsTemplate) {
            $tpl = preg_replace_callback('/\\{([\w\-\/]+)\\}/', function($matches) {
                $name = $matches[1];
                if (isset($this->moreActions[$name])) {
                    $url = $this->createUrl($name);

                    return '<li>' . call_user_func($this->moreActions[$name], $url) . '</li>';
                } else {
                    return '<li>' . $matches[0] . '</li>';
                }
            }, $this->moreActionsTemplate);

            $btn = '<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">More <span class="caret"></span></button>';
            $menu = Html::tag('ul', $tpl, ['class' => 'dropdown-menu dropdown-menu-right', 'role' => 'menu']);
            return Html::tag('div', $btn . $menu, ['class' => 'btn-group']);
        }

        return '';
    }

    protected function initDefaultActions()
    {
        if (!isset($this->actions['create'])) {
            $this->actions['create'] = function($url) {
                return Html::tag('a', '<i class="fa fa-plus fa-lg"></i> 创建', [
                    'class' => 'btn btn-success',
                    'href' => $url,
                    'data-action' => 'get.modal',
                ]);
            };
        }
        if (!isset($this->actions['multi-delete'])) {
            $this->actions['multi-delete'] = function($url) {
                return Html::tag('a', '<i class="fa fa-trash fa-lg"></i> ' . Yii::t('yii', 'Delete'), [
                    'class' => 'btn btn-danger',
                    'href' => $url,
                    'data-action' => 'multi-delete.grid-view',
                ]);
            };
        }
    }

    public function createUrl($action)
    {
        if ($this->urlCreator instanceof Closure) {
            return call_user_func($this->urlCreator, $action);
        } else {
            $params[0] = $this->controller ? $this->controller . '/' . $action : $action;

            return Url::toRoute($params);
        }
    }
}