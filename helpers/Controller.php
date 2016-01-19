<?php
namespace app\helpers;

use Yii;
use yii\web\UnauthorizedHttpException;
use yii\web\ForbiddenHttpException;

class Controller extends \yii\web\Controller
{
    public $isAjax;
    public $isPjax;
    public $isPost;
    
    /**
     * @var \yii\web\User
     */
    public $user;
    
    /**
     * @var \yii\web\Request
     */
    public $request;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $request = Yii::$app->getRequest();
        $this->isAjax = $request->getIsAjax();
        $this->isPjax = $request->getIsPjax();
        $this->isPost = $request->getIsPost();
        $this->request = $request;
        $this->user = Yii::$app->user;
        
        if ($this->isAjax) {
            $this->layout = 'ajax';
        }
    }
    
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $excludeActions = $this->excludeActions();
            if (in_array($action->id, $excludeActions)) {
                return true;
            }
            
            if ($this->user->isGuest) {    
                throw new UnauthorizedHttpException();
            }
            
            if ($this->id == 'site') {
                return true;
            }
            
            /* @var $identity \app\models\admin */
            $identity = $this->user->identity;
            if ($identity->admin_role_id == 1) {
                return true;
            }
            
            $acls = $identity->adminRole->acls;
            $define = static::acls();
            if (isset($acls[$this->id])) {
                foreach ($acls[$this->id] as $rule => $true) {
                    if (isset($define[$rule]) && isset($define[$rule]['actions'])
                            && in_array($action->id, $define[$rule]['actions'])) {
                        return true;
                    }
                }
            }
            
            throw new ForbiddenHttpException();
        }
        
        return true;
    }
    
    public static function acls()
    {
        return [];
    }
    
    /**
     * List which actions don't need login.
     * @return array:
     */
    public function excludeActions()
    {
        return [];
    }
}