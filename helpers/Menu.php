<?php
namespace app\helpers;

use Yii;
use yii\base\Object;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Inflector;
use app\models\AdminRole;

/**
 * Menus and ACLs collection class.
 * @property array $config 
 * @property array $acls
 */
class Menu extends Object
{
    /**
     * According the ACLs collect the menus.
     * @param array $acls
     * @return array
     */
    public function menus($acls)
    {
        $config = $this->getConfig();
        $menus = [];
        foreach ($acls as $controller => $acl) {
            if (isset($config[$controller])) {
                $define = $config[$controller];
                $tab = $define['_tab_'];
                foreach ($acl as $rule => $true) {
                    if (isset($define[$rule]['menus'])) {
                        if (!isset($menus[$tab])) {
                            $menus[$tab] = [];
                        }
                        foreach ($define[$rule]['menus'] as $key => $item) {
                            if (!isset($menus[$tab][$key])) {
                                $menus[$tab][$key] = [];
                            }
                            foreach ($item as &$li) {
                                if (isset($li['route'])) {
                                    $li['href'] = Url::to($li['route']);
                                    unset($li['route']);
                                }
                                
                            }
                            $menus[$tab][$key] = array_merge($menus[$tab][$key], $item);
                        }
                    }
                }
            }
        }
    
        return $menus;
    }
    
    /**
     * According the ACLs collect who can have ACLs.
     * @param array $acls
     * @return array
     */
    public function options($acls)
    {
        $config = $this->getConfig();
        $options = [];
        foreach ($acls as $controller => $acl) {
            if (isset($config[$controller])) {
                $define = $config[$controller];
                $tab = $define['_tab_'];
                $label = $define['_label_'];
                foreach ($acl as $rule => $true) {
                    if (isset($define[$rule])) {
                        if (!isset($options[$tab])) {
                            $options[$tab] = [];
                        }
                        if (!isset($options[$tab][$label])) {
                            $options[$tab][$label] = [];
                        }
                        $options[$tab][$label][$rule] = [
                            'label' => $define[$rule]['label'],
                            'controller' => $controller
                        ];
                    }
                }
            }
        }
        
        return $options;
    }
    
    /**
     * According to the role of the ACL collection he can operate the permissions.
     * @param int $id the id of the AdminRole
     * @return array
     */
    public function displayAcls($id)
    {
        $model = AdminRole::findOne($id);
        return $this->options($model->acls);
    }
    
    private $_acls;
    /**
     * Collect all ACLs.
     * @return array
     */
    public function getAcls()
    {
        if ($this->_acls !== null) {
            return $this->_acls;
        }
        
        $this->_acls = [];
        foreach ($this->getConfig() as $controller => $define) {
            foreach ($define as $key => $rules) {
                if ($key[0] != '_') {
                    $this->_acls[$controller][$key] = '1';
                }
            }
        }
        
        return $this->_acls;
    }
    
    private $_config;
    /**
     * Collect all menus from the controllers.
     * @return array
     */
    public function getConfig()
    {
        if ($this->_config !== null) {
            return $this->_config;
        }
        
        $controllerDir = Yii::getAlias('@app/controllers');
        $controllerFiles = glob($controllerDir . '/*Controller.php');
        $controllerNamespace = 'app\\controllers';
        $this->_config = [];
    
        foreach ($controllerFiles as $file) {
            $controllerClass = $controllerNamespace . '\\' . basename($file, '.php');
            if (class_exists($controllerClass)) {
                $class = new \ReflectionClass($controllerClass);
                if ($class->isSubclassOf('yii\\web\\Controller') && $class->hasMethod('acls')) {
                    $method = $class->getMethod('acls');
                    if ($method->isPublic() && $method->isStatic()) {
                        $basename = Inflector::camel2id(substr(basename($file), 0, -14));
                        $this->_config[$basename] = $controllerClass::acls();
                    }
                }
            }
        }
        
        return $this->_config;
    }
} 