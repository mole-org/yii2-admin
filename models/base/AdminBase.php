<?php
namespace app\models\base;

use Yii;

/**
 * This is the model class for table "{{%admin}}".
 *
 * @property integer $id
 * @property integer $admin_role_id
 * @property integer $parent_id
 * @property string $parent_path
 * @property string $username
 * @property string $password
 * @property string $realname
 * @property boolean $status
 * @property string $last_ip
 * @property string $create_time
 * @property string $update_time
 * @property string $last_time
 */
class AdminBase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admin_role_id', 'parent_id'], 'integer'],
            [['status'], 'boolean'],
            [['create_time', 'update_time', 'last_time'], 'safe'],
            [['parent_path'], 'string', 'max' => 255],
            [['username', 'realname'], 'string', 'max' => 25],
            [['password'], 'string', 'max' => 33],
            [['last_ip'], 'string', 'max' => 128],
            [['username'], 'unique']
        ];
    }
}
