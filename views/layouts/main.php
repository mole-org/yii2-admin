<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\helpers\Menu;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Admin Management">
  <meta name="author" content="mole">
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>
  
<body>
<?php $this->beginBody() ?>
  <div id="wrapper">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
      <div id="ajax-loading"><span class="expand"></span></div>
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?= Yii::$app->getHomeUrl(); ?>"><strong><?= Yii::$app->name ?></strong></a>
      </div>
      <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
          </a>
          <ul class="dropdown-menu dropdown-user">
            <li><a href="#"><i class="fa fa-user fa-fw"></i> <?= Yii::$app->user->identity->realname; ?></a>
            </li>
            <li><a href="<?= Url::toRoute(['/site/password']) ?>" data-action="get.modal"><i class="fa fa-lock fa-fw"></i> 更新密码</a>
            </li>
            <li class="divider"></li>
            <li><a href="<?= Url::toRoute(['/site/logout']) ?>" data-pjax="0" data-method="post"><i class="fa fa-sign-out fa-fw"></i> 注销</a>
            </li>
          </ul>
        </li>
      </ul>
      <div class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
          <?php 
            $m = new Menu();
            $menus = $m->menus($m->acls);
            $tabs = array_keys($menus);
            $panels = array_values($menus);
            $i = 0;
          ?>
          <table>
            <tr>
              <td class="td-tabs">
                <ul class="nav nav-tabs tabs-left">
                  <?php foreach ($tabs as $tab): ?>
                  <li <?php if ($i == 0): ?> class="active"<?php endif ?>><?= Html::tag('a', $tab, ['href' => "#menu-tab-$i", 'data-toggle' => 'tab']) ?></li>
                  <?php ++$i ?>
                  <?php endforeach ?>
                </ul>
              </td>
              <td class="td-panels">
                <div class="tab-content">
                  <?php $i = 0; ?>
                  <?php foreach ($panels as $panel): ?>
                  <div class="tab-panel fade in<?php if ($i == 0): ?> active<?php endif ?>" id="menu-tab-<?= $i ?>">
                    <?php foreach ($panel as $group => $lis): ?>
                    <div class="menu-block">
                      <div class="menu-block-title"><?= $group ?></div>
                      <ul>
                        <?php foreach ($lis as $li): ?>
                        <li>
                          <?php
                            $label = $li['label'];
                            unset($li['label']);
                            echo Html::tag('a', $label, $li);
                          ?>
                        </li>
                        <?php endforeach ?>
                      </ul>
                    </div>
                    <?php endforeach ?>
                  </div>
                  <?php ++$i ?>
                  <?php endforeach ?>
                </div>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </nav>
    <div id="page-wrapper">
      <?php if (isset($this->params['breadcrumbs']) && $this->params['breadcrumbs']): ?>
      <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
      <?php endif ?>
      <?= $content ?>
    </div>
  </div>
  <div class="messages-right">
    <?php include __DIR__ . '/_message.php' ?>
  </div>
  <?php include __DIR__ . '/_dialog.php' ?>
  <?php include __DIR__ . '/_alert.php' ?>
  <?php include __DIR__ . '/_confirm.php' ?>
  <?php include __DIR__ . '/_login.php' ?>
<?php $this->endBody() ?>
<?php if (isset($this->blocks['js'])) echo $this->blocks['js'] ?>
</body>
</html>
<?php $this->endPage() ?>
