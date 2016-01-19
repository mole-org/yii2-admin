<?php
namespace app\models;

use Yii;
use app\models\AdminRole;

/**
 * This is the model class for table "{{%admin}}".
 */
class Admin extends \app\models\base\AdminBase
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // attach event or init other things.
        $this->on(self::EVENT_BEFORE_INSERT, function($event) {
            $this->create_time = date('Y-m-d H:i:s');
            $this->update_time = $this->create_time;
            $this->last_time = $this->create_time;
            $this->password = $this->hashPassword($this->password);
        });
        
        $this->on(self::EVENT_BEFORE_UPDATE, function($event) {
            $this->update_time = date('Y-m-d H:i:s');
        });
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(
            parent::rules(),
            [
                [['username', 'realname', 'password', 'admin_role_id'], 'required', 'on' => 'create'],
                [['username', 'realname', 'admin_role_id'], 'required', 'on' => 'update'],
            ]
        );
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'admin_role_id' => '角色',
            'parent_id' => '创建者',
            'parent_path' => '父路径',
            'username' => '用户名',
            'password' => '密码',
            'realname' => '真实姓名',
            'status' => '状态',
            'last_ip' => '最后登录IP',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'last_time' => '最后登录时间',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(static::className(), ['id' => 'parent_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminRole()
    {
        return $this->hasOne(AdminRole::className(), ['id' => 'admin_role_id']);
    }
    
    /**
     * @inheritdoc
     */
    public function insert($runValidation = true, $attributes = null)
    {
        try {
            $result = parent::insert($runValidation, $attributes);
        } catch (\yii\db\IntegrityException $e) {
            $result = false;
            $this->addError('username', strtr('用户名<b>{username}</b>已经存在。', ['{username}' => $this->username]));
        }
    
        return $result;
    }
    
    /**
     * Validates password
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return md5($password) === $this->password;
    }
    
    /**
     * Encrypt the raw password.
     * @param string $password
     * @return string
     */
    public function hashPassword($password)
    {
        return md5($password);
    }
}