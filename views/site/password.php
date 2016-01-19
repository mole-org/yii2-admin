<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PasswordForm */
/* @var $form yii\bootstrap\ActiveForm */

$this->title = '更新密码';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-form-block">
  <?php 
    $form = ActiveForm::begin([
      'id' => $model->formName() . '-form', 
      'options' => ['class' => 'model-form'],
      'layout' => 'horizontal', 
      'fieldConfig' => [
        'horizontalCssClasses' => [
          'label' => 'col-sm-3',
          'offset' => 'col-sm-offset-3',
          'wrapper' => 'col-sm-3',
        ]
      ]
    ]); 
  ?>
  <input style="display:none" type="text" /> <input style="display:none" type="password" />
  <?= $form->field($model, 'password_old')->passwordInput(['maxlength' => 32]) ?>

  <?= $form->field($model, 'password')->passwordInput(['maxlength' => 32]) ?>

  <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => 32]) ?>

  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-5">
      <?= Html::submitButton(
            '更新', 
            [
              'data-action' => 'update.model-form', 
              'class' => 'btn btn-primary'
            ]
          ) 
      ?>
      <button type="button" class="btn btn-default modal-close" data-dismiss="modal">关闭</button>
    </div>
  </div>

  <?php ActiveForm::end(); ?>
</div>