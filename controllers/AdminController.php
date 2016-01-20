<?php
namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use app\models\Admin;
use app\models\AdminSearch;
use app\models\AdminRole;
use app\helpers\Controller;
use app\helpers\UserError;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminController extends Controller
{
    /**
     * Define the ACLs for this controller.
     * @return array
     */
    public static function acls()
    {
        return [
            '_tab_' => ['label' => '系统'],
            '_label_' => '用户管理', 
            'read' => [
                'label' => '读',
                'actions' => ['index', 'view'],
                'menus' => [
                    [
                        'column' => ['label' => '用户管理'],
                        'items' => [
                            ['label' => '用户管理', 'route' => ['admin/index', 'sort' => '-id']],
                        ],
                    ],
                ],
            ],
            'write' => [
                'label' => '写',
                'actions' => ['create', 'update', 'delete', 'multi-delete', 'password']
            ],
        ];
    }

    /**
     * Lists all Admin models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->search($this->request->get('AdminSearch'));
    }

    /**
     * Displays a single Admin model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Admin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @throws UserError if this model generate errors.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Admin();
        $model->scenario = 'create';

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
            return $this->render('create', [
                'model' => $model,
                'honors' => AdminRole::honorMap(),
            ]);
        }
    }

    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @throws UserError if this model generate errors.
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';
        
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
                'honors' => AdminRole::honorMap(),
            ]);
        }
    }

    /**
     * Deletes an existing Admin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($id != 1) {
            $this->findModel($id)->delete();
        }
        
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
     * Change password.
     * @param integer $id
     * @return string
     */
    public function actionPassword($id)
    {
        throw new ForbiddenHttpException();
    }

    /**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException();
        }
    }
    
    /**
     * Lists all Admin models.
     * @param array $params
     * @return string
     */
    protected function search($params)
    {
        $searchModel = new AdminSearch();
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'honors' => AdminRole::honorMap(),
        ]);
    }
}
