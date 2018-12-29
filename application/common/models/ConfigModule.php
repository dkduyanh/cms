<?php

namespace common\models;

use common\models\main\Configuration;
use yii\base\Model;
use yii\helpers\ArrayHelper;

abstract class ConfigModule extends Model
{
    protected $_installed = true;
    protected $_module;
    private $_models;
    private $_map = [];

    /**
     * GeneralConfigurationForm constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->bindValue();
    }

    /**
     * Load configuration values from DB
     * @return array
     */
    protected function loadFromDB()
    {
        return ArrayHelper::index(Configuration::findByModule($this->_module), 'code');
    }

    /**
     * Return all configuration models
     * @return array
     */
    public function getModels()
    {
        if(empty($this->_models)){
            $this->_models = $this->loadFromDB();
        }
        return $this->_models;
    }

    /**
     * Get moodel
     * @param $key
     * @return bool|mixed
     */
    public function getModel($key)
    {
        $models = $this->getModels();
        return isset($models[$key]) ?  $models[$key] : false;
    }

    /**
     * Map all configurations to attributes
     * @return array [formAttribute => modelAttribute]
     */
    abstract function getAttributesMap();

    /**
     * Bind configuration values from model to class attributes
     */
    protected function bindValue()
    {
        $map = $this->getAttributesMap();
        $models = $this->getModels();
        foreach($map as $attr => $key)
        {
            $code = $this->_module.'.'.$key;
            if(property_exists($this, $attr) && isset($models[$code])){
                $this->$attr = $models[$code]->value;
            } else {
                $this->_installed = false;
            }
        }
    }

    /**
     * Check if module is installed properly
     * @return bool
     */
    public function hasInstalled()
    {
        return $this->_installed;
    }

    /**
     * Save new value
     */
    public function save()
    {
        if($this->validate())
        {
            $map = $this->getAttributesMap();
            $models = $this->getModels();
            foreach($map as $attr => $key)
            {
                $code = $this->_module.'.'.$key;
                if(property_exists($this, $attr) && isset($models[$code])){
                    Configuration::setValue($models[$code]->code, $this->$attr);
                    /*$models[$code]->value = $this->$attr;
                    $models[$code]->save();*/
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Install configurations
     * @return bool
     */
    public function install(){

        foreach($this->getAttributesMap() as $att => $key)
        {
            $code = $this->_module.'.'.$key;
            if(Configuration::getValue($code) === false){
                Configuration::setValue($code);
            }
        }
    }

    /**
     * Uninstall configuration
     * @return bool
     */
    public function uninstall()
    {
        return true;
    }
}