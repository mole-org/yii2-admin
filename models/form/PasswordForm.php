<?php
namespace app\models\form;

use Yii;

/**
 * Change login use password.
 */
class PasswordForm extends \yii\base\Model
{
    public $password_old;
    public $password;
    public $password_repeat;
    
    private $_user;
    
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = Yii::$app->user;
        }
        
        return $this->_user;
    }
    
    public function rules()
    {
        return [
            [['password_old', 'password', 'password_repeat'], 'required'],
            [['password'], 'compare'],
            [['password_old'], 'validatePassword']
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'password_old' => '原始密码',
            'password' => '新密码',
            'password_repeat' => '确认新密码'
        ];
    }
    
    public function validatePassword()
    {
        $user = $this->getUser();
        if (!$user->identity->validatePassword($this->password_old)) {
            $this->addError('password_old', '原始密码错误');
            return false;
        }
        
        return true;
    }
    
    public function save()
    {
        if ($this->validate()) {
            /* @var $model \app\models\Admin */
            $model = $this->getUser()->identity;
            $model->password = $model->hashPassword($this->password);
            $model->save();
            return true;
        }
        
        return false;
    }
}