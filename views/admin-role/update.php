<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AdminRole */

$this->title = '更新角色: ' . ' ' . $model->honor;
$this->params['breadcrumbs'][] = ['label' => '角色列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->honor, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="admin-role-update">
  <?php include __DIR__ . '/_form.php'; ?>
</div>
