<?php

namespace common\models\cms;

use common\models\cms\dao\TblCmsTypes;

class Type extends TblCmsTypes
{
	const   IS_VISIBLE = 1,
			IS_INVISIBLE = 0;

    const   VALUE_YES = 1,
            VALUE_NO = 0;

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFields()
    {
        return $this->hasMany(Field::className(), ['id' => 'field_id'])->viaTable('{{%cms_type_field}}', ['type_id' => 'id']);
    }

    public function getField($fieldId)
    {

    }
}