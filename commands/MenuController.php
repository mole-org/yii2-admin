<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

/**
 * This command generate the Menu and ACL config file.
 */
class MenuController extends Controller
{
    public function actionIndex()
    {
        $menu = new \app\helpers\Menu();
        $res = $menu->options($menu->acls);
        var_dump($res);
    }
}