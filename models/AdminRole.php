<?php
namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Admin;

/**
 * This is the model class for table "{{%admin_role}}".
 */
class AdminRole extends \app\models\base\AdminRoleBase
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // attach event or init other things.
        $this->on(self::EVENT_BEFORE_VALIDATE, function($event) {
            if (!$this->acls) {
                $this->acls = [];
            }
            if (is_array($this->acls)) {
                $this->acls = json_encode($this->acls, JSON_FORCE_OBJECT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
            }
            $this->admin_path = ',' . trim($this->admin_path, ',') . ',';
        });
        
        $this->on(self::EVENT_BEFORE_INSERT, function($event) {
            $this->create_time = time();
            $this->update_time = $this->create_time;
        });
        
        $this->on(self::EVENT_BEFORE_UPDATE, function($event) {
            $this->update_time = time();
        });
        
        $this->on(self::EVENT_AFTER_FIND, function($event) {
            if ($this->id == 1) {
                $this->acls = Yii::$app->menu->acls;
            } else {
                $this->acls = json_decode($this->acls, true);
            }
        });
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(
            parent::rules(),
            []
        );
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'admin_id' => '创建者',
            'admin_path' => '创建者路径',
            'honor' => '角色',
            'acls' => '权限',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne(Admin::className(), ['id' => 'admin_id']);
    }
    
    /**
     * Make a map for id => honor.
     * @return array
     */
    public static function honorMap()
    {
        $rows = static::find()
        ->asArray()
        ->select(['id', 'honor'])
        ->orderBy(['id' => SORT_ASC])
        ->all();
    
        return ArrayHelper::map($rows, 'id', 'honor');
    }
}