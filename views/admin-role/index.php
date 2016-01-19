<?php
use yii\helpers\Html;
use app\helpers\grid\GridView;
use app\helpers\grid\ActionColumn;
use app\helpers\grid\CheckboxColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdminRoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $id string */

$this->title = '角色列表';
$this->params['breadcrumbs'][] = $this->title;
$id = 'admin-role-grid';
?>
<div class="row">
  <div class="col-sm-8 admin-role-index">
    <?= GridView::widget([
      'id' => $id,
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => [
        ['class' => CheckboxColumn::className()],
        'id',
        'honor',
        [
          'attribute' => 'admin_id',
          'content' => function($model, $key, $index, $column) {
            return isset($model['admin']['username']) ? $model['admin']['username'] : '';
          }
        ],
        // 'admin_path',
        // 'acls:ntext',
        // 'create_time',
        // 'update_time',
        ['class' => ActionColumn::className(), 'template' => '{view} {update} {delete}'],
      ],
    ]); ?>
  </div>
</div>