<?php
namespace app\helpers\gii\model;

use Yii;
use yii\gii\CodeFile;

class Generator extends \yii\gii\generators\model\Generator
{
    /**
     * @inheritdoc
     */
    public function requiredTemplates()
    {
        return ['base-model.php', 'model.php'];
    }
    
    /**
     * @inheritdoc
     */
    public function generate()
    {
        $files = [];
        $relations = $this->generateRelations();
        $db = $this->getDbConnection();
        foreach ($this->getTableNames() as $tableName) {
            $className = $this->generateClassName($tableName);
            $tableSchema = $db->getTableSchema($tableName);
            $params = [
                'tableName' => $tableName,
                'className' => $className,
                'tableSchema' => $tableSchema,
                'labels' => $this->generateLabels($tableSchema),
                'rules' => $this->generateRules($tableSchema),
                'relations' => isset($relations[$className]) ? $relations[$className] : [],
            ];
            $files[] = new CodeFile(
                Yii::getAlias('@' . str_replace('\\', '/', $this->ns)) . '/base/' . $className . 'Base.php',
                $this->render('base-model.php', $params)
            );
            $files[] = new CodeFile(
                Yii::getAlias('@' . str_replace('\\', '/', $this->ns)) . '/' . $className . '.php',
                $this->render('model.php', $params)
            );
        }
    
        return $files;
    }
}