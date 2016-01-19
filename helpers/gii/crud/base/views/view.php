<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">
  <div class="detail-view">
    <div class="detail-view-heading">
      <div class="detail-view-toolbar btn-group">
        <?= '<?=' ?> Html::a('更新', ['update', <?= $urlParams ?>], ['class' => 'btn btn-primary']) <?= "?>\n" ?>
        <?= '<?=' ?> Html::a('删除', ['delete', <?= $urlParams ?>], [
          'class' => 'btn btn-danger',
          'data' => [
            'action' => 'delete.view',
          ],
        ]) <?= "?>\n" ?>
      </div>
    </div>

    <?= "<?= " ?>DetailView::widget([
      'model' => $model,
      'attributes' => [
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
  foreach ($generator->getColumnNames() as $name) {
    echo "        '" . $name . "',\n";
  }
} else {
  foreach ($generator->getTableSchema()->columns as $column) {
    $format = $generator->generateColumnFormat($column);
    echo "        '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
  }
}
?>
      ],
    ]) ?>

  </div>
</div>
