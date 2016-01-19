<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $id string */

$id = 'admin-form';
?>

<div class="admin-form-block">
  <?php 
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
  ?>
  <input style="display:none" type="text" /> <input style="display:none" type="password" />
  <?= $form->field($model, 'admin_role_id')->dropDownList($honors, ['prompt' => '']) ?>

  <?= $form->field($model, 'username')->textInput(['maxlength' => 25]) ?>

  <?= $form->field($model, 'realname')->textInput(['maxlength' => 25]) ?>

  <?php if ($model->isNewRecord): ?>
  <?= $form->field($model, 'password')->passwordInput(['maxlength' => 33, 'value' => '']) ?>
  <?php endif ?>

  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-5">
      <?= Html::submitButton(
            $model->isNewRecord ? '创建' : '更新', 
            [
              'data-action' => $model->isNewRecord ? 'create.model-form' : 'update.model-form', 
              'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
            ]
          ) 
      ?>
      <button type="button" class="btn btn-default modal-close" data-dismiss="modal">关闭</button>
    </div>
  </div>

  <?php ActiveForm::end(); ?>

</div>
<?php $this->beginBlock('js') ?>
<script>
jQuery(function($) {
  'use strict';

  // Custom javascript
});
</script>
<?php $this->endBlock() ?>