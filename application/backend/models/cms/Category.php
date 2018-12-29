<?php

namespace backend\models\cms;

use common\library\utils\ArrayTreeBuilder;
use yii\helpers\ArrayHelper;

class Category extends \common\models\cms\Category
{

    /**
     * @return string
     */
    public function getStatusColorClass()
    {
        return self::statusLabelClasses()[$this->status];
    }

    public static function statusLabelClasses()
    {
        return [
            Post::STATUS_ACTIVE => 'label label-success',
            Post::STATUS_INACTIVE => 'label label-danger',
        ];
    }

    /**
     * @return \common\library\utils\unknown[]|\number[]
     */
    public static function listAllInTree($separate = false, $exceptId = null)
    {
        $data = (new ArrayTreeBuilder(ArrayHelper::toArray(self::find()->all())))->buildFlatTree();
        if($exceptId)
        {
        	foreach($data as $key => $cat)
        	{
        		if($cat['id'] == $exceptId){
        			unset($data[$key]);
        			break;
        		}
        	}
        	unset($key); unset($cat);
        }
        if($separate)
        {
        	foreach ($data as &$cat)
        	{
        		for($i=0; $i<$cat['level']; $i++)
        		{
        			$cat['name'] = $separate.$cat['name'];
        		}
        	}
        	unset($cat);
        }
        return $data;
    }


}