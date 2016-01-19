<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Admin;

/**
 * AdminSearch represents the model behind the search form about `app\models\Admin`.
 */
class AdminSearch extends Admin
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        // bypass scenarios() implementation in the parent class
        \yii\db\ActiveRecord::init();
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'admin_role_id', 'parent_id'], 'integer'],
            [['parent_path', 'username', 'password', 'realname', 'last_ip', 'create_time', 'update_time', 'last_time'], 'safe'],
            [['status'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Admin::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->setAttributes($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'admin_role_id' => $this->admin_role_id,
            'parent_id' => $this->parent_id,
            'status' => $this->status,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'last_time' => $this->last_time,
        ]);

        $query->andFilterWhere(['like', 'parent_path', $this->parent_path])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'realname', $this->realname])
            ->andFilterWhere(['like', 'last_ip', $this->last_ip]);

        return $dataProvider;
    }
}
