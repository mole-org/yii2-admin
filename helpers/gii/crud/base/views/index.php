<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>
use yii\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "app\\helpers\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
use app\helpers\grid\ActionColumn;
use app\helpers\grid\CheckboxColumn;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $id string */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
$id = '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-grid';
?>
<div class="row">
  <div class="col-sm-12 <?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?= " ?>GridView::widget([
      'id' => $id,
      'dataProvider' => $dataProvider,
      <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n      'columns' => [\n" : "'columns' => [\n"; ?>
        ['class' => CheckboxColumn::className()],
<?php
  $count = 0;
  if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
      if (++$count < 6) {
        echo "        '" . $name . "',\n";
      } else {
        echo "        // '" . $name . "',\n";
      }
    }
  } else {
    foreach ($tableSchema->columns as $column) {
      $format = $generator->generateColumnFormat($column);
      if (++$count < 6) {
        echo "        '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
      } else {
        echo "        // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
      }
    }
  }
?>
        ['class' => ActionColumn::className(), 'template' => '{view} {update} {delete}'],
      ],
    ]); ?>
<?php else: ?>
    <?= "<?= " ?>ListView::widget([
      'dataProvider' => $dataProvider,
      'itemOptions' => ['class' => 'item'],
      'itemView' => function ($model, $key, $index, $widget) {
        return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
      },
    ]) ?>
<?php endif; ?>
  </div>
</div>