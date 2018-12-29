<?php

namespace common\models\main;

use common\models\main\dao\TblConfiguration;
use yii\caching\TagDependency;

/**
 * Class Configuration
 * @package common\models\main
 *
 * Configurations are pieces of data that used to store various preferences and settings.
 * Each configuration consists of a code-value pair.
 * A Code is a unique identifier for a configuration value. Code includes 2 parts: module and key which separated by a dot (.)
 * You can retrieve a configuration value by using code or module-key
 *
 * Example:
 *   MyConf.A   ==> MyConf is module, A is key and MyConf.A is a unique code
 *   MyConf.A.B ==> MyConf is module, A.B is key
 *
 */
class Configuration extends TblConfiguration
{
    const SEPARATE = '.';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['value'], 'safe'],
            [['code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return bool|string
     */
    public function getModuleName()
    {
        return substr($this->code, 0, strpos($this->code, self::SEPARATE));
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        self::invalidateCacheDependency(self::tableName());
        parent::afterSave($insert, $changedAttributes);
    }

    public static function findByCode($code)
    {
        $key = 'CONF_'.$code;
        $data = self::getFromCache($key);
        if($data === false){
            $data = Configuration::find()->where(['code' => $code])->one();
            self::setCache($key, $data, DEFAULT_LONG_CACHE_EXPIRED, new TagDependency(['tags' => self::tableName()]));
        }
        return $data;
    }

    /**
     * @param $module
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findByModule($module)
    {
        $key = 'CONFIGS_BY_MODULE'.$module;
        $data = self::getFromCache($key);
        if($data === false) {
            $data = self::find()->where(['like', 'code', $module . self::SEPARATE . '%', false])->all();
            self::setCache($key, $data, DEFAULT_LONG_CACHE_EXPIRED, new TagDependency(['tags' => [$key, self::tableName()]]));
        }
        return $data;
    }

    /**
     * Retrieves an configuration value based on an configuration code.
     * If the configuration does not exist, then the return value will be false.
     * The $default value will be returned if the options does not exist or does not have a value (NULL)
     *
     * @param $code
     * @param null $default
     */
    public static function getValue($code, $default = false)
    {
        $conf = self::findByCode($code);
        if($conf === null || ($conf->value === null && $default !== false)){
            return $default;
        }
        return $conf->value;
    }

    /**
     * Retrieves configuration value base on an path.
     * @param $module
     * @param $key
     * @param bool $default
     * @return bool|mixed|null
     */
    public static function getByKey($module, $key, $default = false)
    {
        if(isset($module) && $module != ''){
            $module .= '.';
        }
        $code = $module.$key;
        return self::getValue($code, $default);
    }

    /**
     * Update the value of configuration that was aldready created.
     * If the configuration does not exist and $createIfNotExists is TRUE, it will be created with the provided value.
     * if the $value is not in string or number format. It will be serialized . So, if you want to store array value in Json, please convert it to string by encoding it with functions liked json_encode() before assigning to configuration.
     *
     * @param $code
     * @param null $value
     * @param bool $createIfNotExists Default TRUE
     * @return bool
     */
    public static function setValue($code, $value = null, $createIfNotExists = true)
    {
        //check if configuration was created?
        if(self::getValue($code) === false){
            if(!$createIfNotExists){
                return false;
            }
            $conf = new self();
            $conf->code = $code;
        } else {
            $conf = self::findByCode($code);
        }

        //serialize non-primitive value
        if($value !== null && !is_numeric($value) && !is_string($value)){
            $value = serialize($value);
        }

        //Don't update unchanged value
        if(!$conf->isNewRecord && $conf->value === $value){
            return false;
        }

        //set new value to configuration
        $conf->value = $value;
        return $conf->save();
    }
}