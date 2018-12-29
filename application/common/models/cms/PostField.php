<?php

namespace common\models\cms;

use common\models\cms\dao\TblCmsPostField;

class PostField extends TblCmsPostField {

	public function beforeSave( $insert ) {
		return parent::beforeSave( $insert );
	}
}