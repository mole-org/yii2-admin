<?php
namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use app\models\AdminRole;
use app\models\AdminRoleSearch;
use app\helpers\Controller;
use app\helpers\UserError;

/**
 * AdminRoleController implements the CRUD actions for AdminRole model.
 */
class AdminRoleController extends Controller
{
    /**
     * Define the ACLs for this controller.
     * @return array
     */
    public static function acls()
    {
        return [
            '_tab_' => ['label' => '系统'],
            '_label_' => '角色管理',
            'read' => [
                'label' => '读',
                'actions' => ['index', 'view'],
                'menus' => [
                    [
                        'column' => ['label' => '用户管理'],
                        'items' => [
                            [
                                'label' => '角色列表',
                                'route' => ['admin-role/index', 'sort' => '-id'],
                            ],
                        ],
                    ],
                ],
            ],
            'write' => [
                'label' => '写',
                'actions' => ['create', 'update', 'delete', 'multi-delete']
            ]
        ];
    }

    /**
     * Lists all AdminRole models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->search($this->request->get('AdminRoleSearch'));
    }

    /**
     * Displays a single AdminRole model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
            'displayAcls' => Yii::$app->menu->options($model->acls),
        ]);
    }

    /**
     * Creates a new AdminRole model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @throws UserError if this model generate errors.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AdminRole();
        $identity = $this->user->identity;

        if ($this->isPost) {
            $model->attributes = $this->request->post($model->formName(), []);
            $model->admin_id = $identity->id;
            $model->admin_path = $identity->parent_path . $identity->id;
            if ($model->save()) {
                if (Yii::$app->response->acceptMimeType == 'application/json') {
                    return ['pk' => $model->id, 'data' => $model->toArray()];
                } elseif (Yii::$app->response->acceptMimeType == 'text/grid') {
                    return $this->search(['id' => $model->id]);
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
                'displayAcls' => Yii::$app->menu->displayAcls($identity->admin_role_id),
            ]);
        }
    }

    /**
     * Updates an existing AdminRole model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @throws UserError if this model generate errors.
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($this->isPost) {
            $model->attributes = $this->request->post($model->formName(), []);
            if ($model->save()) {
                if (Yii::$app->response->acceptMimeType == 'application/json') {
                    return ['pk' => $model->id, 'data' => $model->toArray()];
                } elseif (Yii::$app->response->acceptMimeType == 'text/grid') {
                    return $this->search(['id' => $model->id]);
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
                'displayAcls' => Yii::$app->menu->displayAcls($this->user->identity->admin_role_id),
            ]);
        }
    }

    /**
     * Deletes an existing AdminRole model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        throw new ForbiddenHttpException();
        $this->findModel($id)->delete();

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
            list ($id) = explode('|', $_id);
            if (($model = Admin::findOne($id)) !== null) {
                $model->delete();
            }
        }
        
        if (!$this->isAjax) {
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the AdminRole model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdminRole the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdminRole::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException();
        }
    }
    
    /**
     * Lists all AdminRole models.
     * @param array $params
     * @return string
     */
    protected function search($params)
    {
        $searchModel = new AdminRoleSearch();
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
