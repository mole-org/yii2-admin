<?php
namespace app\helpers;

/**
 * Overwrite yii\web\AssetManager::loadDummyBundle function,
 * because the framework always publish assets even if you 
 * config map for assets.
 */
class AssetManager extends \yii\web\AssetManager
{
    /**
     * @var boolean when config assets map in config file, 
     * whether need publish assets.
     */
    public $isPublish = true;
    
    private $_dummyBundles = [];
    
    /**
     * @inheritdoc
     */
    protected function loadDummyBundle($name)
    {
        if (!isset($this->_dummyBundles[$name])) {
            $this->_dummyBundles[$name] = $this->loadBundle($name, [
                'js' => [],
                'css' => [],
                'depends' => [],
            ], $this->isPublish);
        }
        return $this->_dummyBundles[$name];
    }
}