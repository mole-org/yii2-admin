<?php
use yii\helpers\Html;
use app\helpers\grid\GridView;
use app\helpers\grid\ActionColumn;
use app\helpers\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $id string */

$this->title = '用户列表';
$this->params['breadcrumbs'][] = $this->title;
$id = 'admin-grid';
?>
<div class="row">
  <div class="col-sm-12 admin-index">
    <?= GridView::widget([
      'id' => $id,
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => [
        ['class' => CheckboxColumn::className()],
        'id',
        'username',
        'realname',
        [
          'attribute' => 'admin_role_id',
          'filter' => $honors,
          'content' => function($model, $key, $index, $column) use ($honors) {
            return isset($honors[$model['admin_role_id']]) ? $honors[$model['admin_role_id']] : '';
          }
        ],
        [
          'attribute' => 'parent_id',
          'content' => function($model, $key, $index, $column) {
            return $model['parent'] ? $model['parent']['username'] : 'system';
          }
        ],
        // 'parent_path',
        // 'password',
        // 'realname',
        'status:boolean',
        // 'last_ip',
        // 'create_time',
        // 'update_time',
        'last_time',
        ['class' => ActionColumn::className(), 'template' => '{view} {update} {delete} {password}'],
      ],
    ]); ?>
  </div>
</div>
<?php $this->beginBlock('js') ?>
<script>
jQuery(function($) {
  'use strict';
  
  $('#<?= $id ?>')
    .find('tr[data-key="1"]:first')
    .find(':checkbox, .fa-trash').remove()
});
</script>
<?php $this->endBlock() ?>