<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AdminRole */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $id string */

$id = 'admin-role-form';
?>

<div class="admin-role-form-block">
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
  <?= $form->field($model, 'honor')->textInput(['maxlength' => 15]) ?>

  <div class="form-group required">
    <label class="control-label col-sm-3" for="adminrole-acls">权限</label>
    <div class="col-sm-8" id="<?= $model->formName() . '-acl'?>">
    <?php if ($model->id == 1): ?>
      <div style="margin-top: 5px;">拥有所有权限！</div>
    <?php else: ?>
      <?php foreach ($displayAcls as $panel => $items): ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <label class="checkbox-inline">
            <input type="checkbox"> <?= $panel ?>
          </label>
        </div>
        <div class="panel-body">
          <?php foreach ($items as $label => $rules): ?>
          <div class="form-group">
            <label class="acl-label col-sm-3"><?= $label ?></label>
            <div class="col-sm-9">
              <?php foreach ($rules as $key => $rule):?>
              <label class="checkbox-inline">
                <?= Html::checkbox(
                      $model->formName() . '[acls][' . $rule['controller'] . '][' . $key . ']',
                      isset($model->acls[$rule['controller']][$key]),
                      [
                        'value' => '1',
                        'data-rule' => $key,
                      ]
                    ); 
                ?> 
                <?= $rule['label'] ?>
              </label>
              <?php endforeach ?>
            </div>
          </div>
          <?php endforeach ?>
        </div>
      </div>
      <?php endforeach ?>
    <?php endif ?>
    </div>
  </div>

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

  var aclId = '#<?= $id ?>'
  $(aclId).on('click', ':checkbox', function(event) {
    var $this = $(this)

    if ($this.closest('.panel-heading').length) {
      if ($this.is(':checked')) {
        $this.closest('.panel').find(':checkbox').prop('checked', true);
      } else {
        $this.closest('.panel').find(':checkbox').prop('checked', false);
      }
    } else {
      if ($this.is(':checked') && $this.data('rule') === 'write') {
        $this.closest('div').find(':checkbox[data-rule="read"]').prop('checked', true);
      } else if (!$this.is(':checked') && $this.data('rule') === 'read') {
        $this.closest('div').find(':checkbox[data-rule="write"]').prop('checked', false);
      }

      window.setTimeout(function() {
        $this.closest('.panel').find('.panel-heading :checkbox').trigger('num-change')
      }, 0)
    }

    event.stopPropagation()
  })

  $(aclId).on('num-change', '.panel-heading :checkbox', function() {
    var $this = $(this)

    $this.prop('checked', $this.closest('.panel').find('.panel-body :checkbox:not(:checked)').length === 0)
    return false
  })

  $(aclId).find('.panel-heading :checkbox').trigger('num-change')
});
</script>
<?php $this->endBlock() ?>