<?php
namespace app\models\base;

use Yii;

/**
 * This is the model class for table "{{%admin_role}}".
 *
 * @property integer $id
 * @property integer $admin_id
 * @property string $admin_path
 * @property string $honor
 * @property string $acls
 * @property string $create_time
 * @property string $update_time
 */
class AdminRoleBase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_role}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admin_id'], 'integer'],
            [['acls'], 'required'],
            [['acls'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['admin_path'], 'string', 'max' => 255],
            [['honor'], 'string', 'max' => 15]
        ];
    }
}
