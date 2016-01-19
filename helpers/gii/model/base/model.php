<?php
echo "<?php\n";
?>
namespace <?= $generator->ns ?>;

use Yii;

/**
 * This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
 */
class <?= $className ?> extends <?= '\\' . $generator->ns . '\\base\\' . $className . "Base\n" ?>
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // attach event or init other things.
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
<?php foreach ($labels as $name => $label): ?>
            <?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endforeach; ?>
        ];
    }
}