<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
  $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $id string */

$id = '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form';
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form-block">
  <?= '<?php' ?> 
    $form = ActiveForm::begin([
      'id' => $id, 
      'options' => ['class' => 'model-form'],
      'layout' => 'horizontal', 
      'fieldConfig' => [
        'horizontalCssClasses' => [
          'label' => 'col-sm-3',
          'offset' => 'col-sm-offset-3',
          'wrapper' => 'col-sm-5',
        ]
      ]
    ]); 
  <?= '?>' ?>

<?php foreach ($generator->getColumnNames() as $attribute) {
  if (in_array($attribute, $safeAttributes)) {
    echo "  <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
  }
} ?>
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-5">
      <?= '<?=' ?> Html::submitButton(
            $model->isNewRecord ? '创建' : '更新', 
            [
              'data-action' => $model->isNewRecord ? 'create.model-form' : 'update.model-form', 
              'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
            ]
          ) 
      <?= "?>\n" ?>
      <button type="button" class="btn btn-default modal-close" data-dismiss="modal">关闭</button>
    </div>
  </div>

  <?= "<?php " ?>ActiveForm::end(); ?>

</div>
<?= '<?php' ?> $this->beginBlock('js') <?= "?>\n" ?>
<script>
jQuery(function($) {
  'use strict';

  // Custom javascript
});
</script>
<?= '<?php' ?> $this->endBlock() <?= '?>' ?>
