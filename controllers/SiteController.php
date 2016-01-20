<?php
namespace app\controllers;

use Yii;
use app\helpers\Controller;
use app\models\form\LoginForm;
use app\models\form\PasswordForm;

class SiteController extends Controller
{
    /**
     * Define the ACLs for this controller.
     * @return array
     */
    public static function acls()
    {
        return [
            '_tab_' => '系统',
            '_label_' => '系统信息',
            'read' => [
                'label' => '读',
                'actions' => ['phpinfo'],
                'menus' => [
                    '系统信息' => [
                        [
                            'label' => 'phpinfo',
                            'route' => ['site/phpinfo'],
                            'data-pjax' => 0,
                            'target' => '_blank'
                        ]
                    ]
                ]
            ]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function excludeActions()
    {
        return ['login', 'logout', 'error', 'phpinfo'];
    }
    
    /**
     * Handle exception for different context.
     * @return string|\yii\web\Response
     */
    public function actionError()
    {
        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            return '';
        }
        
        if ($exception instanceof \yii\web\HttpException) {
            $code = $exception->statusCode;
        } else {
            $code = $exception->getCode();
        }
        if ($exception instanceof \yii\base\Exception) {
            $name = $exception->getName();
        } else {
            $name = Yii::t('app', 'Error');
        }
        if ($code) {
            $name .= " (#$code)";
        }
        
        if ($exception instanceof \yii\base\UserException) {
            $message = $exception->getMessage();
            $maps = [
                404 => '您访问的页面不存在。',
                403 => '您无权限执行此操作。',
            ];
            if ($message === '' && $exception instanceof \yii\web\HttpException && isset($maps[$exception->statusCode])) {
                $message = $maps[$exception->statusCode];
            }
        } else {
            $message = Yii::t('app', 'An internal server error occurred.');
        }
        
        if (Yii::$app->getRequest()->getIsAjax()) {
            return "$name: $message";
        } else {
            if ($exception instanceof \yii\web\UnauthorizedHttpException) {
                $exception->statusCode = 302;
                if ($this->request->isGet) {
                    $response = Yii::$app->getResponse();
                    $response->cookies->add(new \yii\web\Cookie([
                        'name' => $this->user->returnUrlParam,
                        'value' => $this->request->absoluteUrl
                    ]));
                }
                return $this->redirect(['login']);
            } else {
                return $this->render('error', [
                    'name' => $name,
                    'message' => $message,
                    'exception' => $exception,
                ]);
            }
        }
    }

    /**
     * Render home page.
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Handle user login. if you already login and rediect to home page.
     * @throws \app\helpers\UserError
     * @return \yii\web\Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = false;
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
            if (!$this->isAjax) {
                $cookies = $this->request->cookies;
                if (isset($cookies[$this->user->returnUrlParam])) {
                    $backUrl = $cookies[$this->user->returnUrlParam]->value;
                    Yii::$app->response->cookies->remove($this->user->returnUrlParam);
                } else {
                    $backUrl = \yii\helpers\Url::home(true);
                }
                
                $this->redirect($backUrl);
            }
        } else {
            if ($this->isAjax && $this->isPost) {
                throw new \app\helpers\UserError($model->getErrors());
            } else {
                return $this->render('login', [
                    'model' => $model,
                ]);
            }
           
        }
    }

    /**
     * For user logout and redirect to login page.
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect('login');
    }
    
    /**
     * Change login user password.
     * @throws \app\helpers\UserError
     * @return string
     */
    public function actionPassword()
    {
        $model = new PasswordForm();
        if ($this->isPost) {
            $model->attributes = $this->request->post($model->formName(), []);
            if (!$model->save()) {
                throw new \app\helpers\UserError($model->getErrors());
            }
        } else {
            return $this->render('password', [
                'model' => $model
            ]);
        }
    }

    /**
     * Render the phpinfo page.
     * @return string
     */
    public function actionPhpinfo()
    {
        ob_start();
        ob_implicit_flush(false);
        phpinfo();
        return ob_get_clean();
    }
}
