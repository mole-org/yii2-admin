<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AdminRole */

$this->title = '创建角色';
$this->params['breadcrumbs'][] = ['label' => '角色列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-role-create">
  <?php include __DIR__ . '/_form.php'; ?>
</div>
