<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AdminRole */

$this->title = $model->honor;
$this->params['breadcrumbs'][] = ['label' => '角色列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('acls') ?>
  <?php if ($model->id == 1): ?>
  拥有所有权限
  <?php else: ?>
  <form class="model-form form-horizontal">
  <?php foreach ($displayAcls as $panel => $items): ?>
  <div class="panel panel-default">
    <div class="panel-heading">
      <?= $panel ?>
    </div>
    <div class="panel-body">
      <?php foreach ($items as $label => $rules): ?>
      <div class="form-group">
        <label class="acl-label col-sm-3"><?= $label ?></label>
        <div class="col-sm-9">
          <?php foreach ($rules as $key => $rule):?>
          <label class="checkbox-inline">

            <?= $rule['label'] ?>
          </label>
          <?php endforeach ?>
        </div>
      </div>
      <?php endforeach ?>
    </div>
  </div>
  <?php endforeach ?>
  </form>
  <?php endif ?>
<?php $this->endBlock() ?>

<div class="admin-role-view">
  <div class="detail-view">
    <div class="detail-view-heading">
      <div class="detail-view-toolbar btn-group">
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
          'class' => 'btn btn-danger',
          'data' => [
            'action' => 'delete.view',
          ],
        ]) ?>
      </div>
    </div>

    <?= DetailView::widget([
      'model' => $model,
      'attributes' => [
        'id',
        'admin_id',
        'admin_path',
        'honor',
        'create_time',
        'update_time',
        [
          'attribute' => 'acls',
          'format' => 'raw',
          'value' => $this->blocks['acls']
        ],
      ],
    ]) ?>

  </div>
</div>
