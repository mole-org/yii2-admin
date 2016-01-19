<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Admin */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => '用户列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-view">
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
        'admin_role_id',
        'parent_id',
        'parent_path',
        'username',
        'password',
        'realname',
        'status:boolean',
        'last_ip',
        'create_time',
        'update_time',
        'last_time',
      ],
    ]) ?>

  </div>
</div>
