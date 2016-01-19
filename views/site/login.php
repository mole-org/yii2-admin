<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use app\assets\AppAsset;

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
  <title><?= Html::encode('Amdin Management') ?></title>
  <?php $this->head() ?>
</head>
  
<body>
<?php $this->beginBody() ?>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
          <div class="panel-heading">
            <strong class="panel-title">用户登录</strong>
          </div>
          <div class="panel-body">
            <form method="post" id="login-form" data-pjax="0">
              <input style="display:none" type="text" /> <input style="display:none" type="password" />
              <fieldset>
                <div class="form-group">
                  <input class="form-control" placeholder="用户名" name="username" type="text" autocomplete="off" required="required" autofocus>
                </div>
                <div class="form-group">
                  <input class="form-control" placeholder="密　码" name="password" type="password" autocomplete="off" required="required">
                </div>
                <!-- Change this to a button or input when using this as a form -->
                <input type="submit" class="btn btn-lg btn-success btn-block" value="登录" />
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="messages-center">
  <?php include __DIR__ . '/../layouts/_message.php' ?>
  </div>
<?php $this->endBody() ?>
<?php if ($model->hasErrors()): ?>
<script>
jQuery(function($) {
  App.error(<?= json_encode($model->getErrors()) ?>)
});
</script>
<?php endif ?>
</body>
</html>
<?php $this->endPage() ?>
