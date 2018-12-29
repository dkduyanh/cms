<?php

namespace common\models\main;


use common\models\main\dao\TblLanguages;

class Language extends TblLanguages
{
    /**
     * Marks this language is default
     */
    const   IS_DEFAULT = 1;

    /**
     * Text directions
     */
    const   DIRECTION_RTL = 'RTL',
            DIRECTION_LTR = 'LTR';

    /**
     * Check if is default language
     * @return bool
     */
    public function isDefault()
    {
        return $this->is_default === self::IS_DEFAULT;
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function listAll()
    {
        return self::find()->orderBy('position ASC')->all();
    }


}