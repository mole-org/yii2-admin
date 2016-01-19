<?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();
$controllerShortName = ltrim(substr($controllerClass, 0, -10), '\\');

if (count($pks) == 1) {
    if (is_subclass_of($class, 'yii\mongodb\ActiveRecord')) {
        $pksParams = "(string)\$model->{$pks[0]}";
    } else {
        $pksParams = "\$model->{$pks[0]}";
    }
} else {
    $params = [];
    foreach ($pks as $pk) {
        if (is_subclass_of($class, 'yii\mongodb\ActiveRecord')) {
            $params[] = "'{$pk}' => (string)\$model->{$pk}";
        } else {
            $params[] = "'{$pk}' => \$model->{$pk}";
        }
    }
    $pksParams = '[' . implode(', ', $params) . ']';
}

echo "<?php\n";
?>
namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use app\helpers\UserError;

/**
 * <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> model.
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
    /**
     * Define the ACLs for this controller.
     * @return array
     */
    public static function acls()
    {
        return [
            '_tab_' => 'Unknown',
            '_label_' => '<?= $controllerShortName ?>',
            'read' => [
                'label' => '读',
                'actions' => ['index', 'view'],
                'menus' => [
                    '<?= $controllerShortName ?>' => [
                        [
                            'label' => 'list',
                            'href' => 'index',
                        ],
                    ],
                ],
            ],
            'write' => [
                'label' => '写',
                'actions' => ['create', 'update', 'delete', 'multi-delete'],
            ],
        ];
    }

    /**
     * Lists all <?= $modelClass ?> models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->search($this->request->get('<?= basename($generator->searchModelClass) ?>'));
    }

    /**
     * Displays a single <?= $modelClass ?> model.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionView(<?= $actionParams ?>)
    {
        return $this->render('view', [
            'model' => $this->findModel(<?= $actionParams ?>),
        ]);
    }

    /**
     * Creates a new <?= $modelClass ?> model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @throws UserError if this model generate errors.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new <?= $modelClass ?>();

        if ($this->isPost) {
            $model->attributes = $this->request->post($model->formName(), []);
            if ($model->save()) {
                if (Yii::$app->response->acceptMimeType == 'application/json') {
                    return ['pk' => <?= $pksParams ?>, 'data' => $model->toArray()];
                } elseif (Yii::$app->response->acceptMimeType == 'text/grid') {
                    return $this->search([<?= $urlParams ?>]);
                } else {
                    return $this->redirect(['index']);
                }
            } else {
                if ($this->isAjax) {
                    throw new UserError($model->getErrors());
                } else {
                    goto REN;
                }
            }
        } else {
            REN:
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing <?= $modelClass ?> model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @throws UserError if this model generate errors.
     * @return mixed
     */
    public function actionUpdate(<?= $actionParams ?>)
    {
        $model = $this->findModel(<?= $actionParams ?>);
        
        if ($this->isPost) {
            $model->attributes = $this->request->post($model->formName(), []);
            if ($model->save()) {
                if (Yii::$app->response->acceptMimeType == 'application/json') {
                    return ['pk' => <?= $pksParams ?>, 'data' => $model->toArray()];
                } elseif (Yii::$app->response->acceptMimeType == 'text/grid') {
                    return $this->search([<?= $urlParams ?>]);
                } else {
                    return $this->redirect(['index']);
                }
            } else {
                if ($this->isAjax) {
                    throw new UserError($model->getErrors());
                } else {
                    goto REN;
                }
            }
        } else {
            REN:
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing <?= $modelClass ?> model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionDelete(<?= $actionParams ?>)
    {
        $this->findModel(<?= $actionParams ?>)->delete();

        if (!$this->isAjax) {
            return $this->redirect(['index']);
        }
    }
    
    /**
     * Multi delete rows.
     */
    public function actionMultiDelete()
    {
        $ids = $this->request->post('ids', []);
        foreach ($ids as $_id) {
            list (<?= '$' . implode(', $', $pks) ?>) = explode('|', $_id);
            if (($model = Admin::findOne(<?= $actionParams ?>)) !== null) {
                $model->delete();
            }
        }
        
        if (!$this->isAjax) {
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the <?= $modelClass ?> model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return <?=                   $modelClass ?> the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(<?= $actionParams ?>)
    {
<?php
if (count($pks) === 1) {
    $condition = '$id';
} else {
    $condition = [];
    foreach ($pks as $pk) {
        $condition[] = "'$pk' => \$$pk";
    }
    $condition = '[' . implode(', ', $condition) . ']';
}
?>
        if (($model = <?= $modelClass ?>::findOne(<?= $condition ?>)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException();
        }
    }
    
    /**
     * Lists all <?= $modelClass ?> models.
     * @param array $params
     * @return string
     */
    protected function search($params)
    {
<?php if (!empty($generator->searchModelClass)): ?>
        $searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>();
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
<?php else: ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?= $modelClass ?>::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
<?php endif; ?>
    }
}
