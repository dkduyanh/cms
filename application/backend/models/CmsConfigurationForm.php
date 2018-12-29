<?php

namespace backend\models;

use common\models\CmsConfiguration;

class CmsConfigurationForm extends CmsConfiguration
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            //posts
            [['postDefaultImage', 'postEditor'], 'string'],
            [['postDuplicateTitlePrefix', 'postDuplicateTitleSuffix', 'postDuplicateStatus'], 'string'],
            [['allowGuestComment', 'commentModeration'], 'integer'],
            [['mediaThumbSize'], 'string'],
	        ['postEditorContentCss', 'validatePostEditorContentCss'],
        ];
    }

	/**
	 * @param string $attribute the attribute currently being validated
	 * @param mixed $params the value of the "params" given in the rule
	 * @param \yii\validators\InlineValidator $validator related InlineValidator instance.
	 * This parameter is available since version 2.0.11.
	 */
	function validatePostEditorContentCss ($attribute, $params, $validator)
	{
		//explode by line
		//o($this->$attribute);
		$cssBundle = explode("\n", $this->$attribute);
		foreach($cssBundle as $cssFile)
		{
			if (!filter_var($cssFile, FILTER_VALIDATE_URL)) {
				$this->addError($attribute, $cssFile.' is not a valid path');
			}
		}
	}
}