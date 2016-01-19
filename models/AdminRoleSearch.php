<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AdminRole;

/**
 * AdminRoleSearch represents the model behind the search form about `app\models\AdminRole`.
 */
class AdminRoleSearch extends AdminRole
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
            [['id', 'admin_id'], 'integer'],
            [['admin_path', 'honor', 'acls', 'create_time', 'update_time'], 'safe'],
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
        $query = AdminRole::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->setAttributes($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'admin_id' => $this->admin_id,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'admin_path', $this->admin_path])
            ->andFilterWhere(['like', 'honor', $this->honor])
            ->andFilterWhere(['like', 'acls', $this->acls]);

        return $dataProvider;
    }
}
