<?php

namespace common\models;


trait ExtrasTrait
{

    /**
     * Load extra data
     */
    public function loadExtraData()
    {
        if(!is_array($this->extras)){
            $this->extras = json_decode($this->extras, true);
        }
    }

    public function encodeExtraData()
    {
        if(is_array($this->extras)){
            $this->extras = json_encode($this->extras);
        }
    }

    /**
     * Get field value from extra data
     * @param $field
     * @return bool
     */
    protected function getExtraData($field){
        if(!empty($this->extras) && is_array($this->extras) && isset($this->extras[$field])){
            return $this->extras[$field];
        }
        return false;
    }

    /**
     * Set field value to extra data
     * @param $field
     * @param $value
     */
    protected function setExtraData($field, $value)
    {
        if(empty($this->extras)){
            $this->extras = [];
        }
        $this->extras = array_merge($this->extras, [$field => $value]);
        v($this->extras);
    }
}