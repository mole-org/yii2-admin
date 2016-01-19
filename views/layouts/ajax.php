<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
?>
<?php $this->beginPage() ?>
<title><?= Html::encode($this->title) ?></title>
<?php $this->head() ?>
<?php $this->beginBody(); ?>
<?php if (isset($this->params['breadcrumbs']) && $this->params['breadcrumbs']): ?>
<?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
<?php endif ?>
<?= $content ?>
<?php $this->endBody() ?>
<?php if (isset($this->blocks['js'])) echo $this->blocks['js'] ?>
<?php $this->endPage() ?>
