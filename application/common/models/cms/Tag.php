<?php

namespace common\models\cms;

use common\models\cms\dao\TblCmsTags;

class Tag extends TblCmsTags
{
	/**
	 * Convert string of tags to array
	 * @param $tags
	 * @param string $delimiter
	 *
	 * @return array
	 */
	public static function strToArray($tags, $delimiter = ',')
	{
		$ret = [];
		//parse tags
		if(!is_array($tags)) {
			$tags = explode($delimiter, trim($tags));
		}
		foreach($tags as $tag) {
			//tag filtering
			$tag = trim($tag);
			if ( $tag != '' ) {
				$ret[] = $tag;
			}
		}
		return $ret;
	}

	/**
	 * @param array $tags
	 * @param string $delimiter
	 *
	 * @return string
	 */
	public static function arrayToString(array $tags, $delimiter = ', '){
		$ret = [];
		foreach($tags as $tag){
			//tag filtering
			$tag = trim($tag);
			if( $tag != ''){
				$ret[] = $tag;
			}
		}
		return implode($delimiter, $ret);
	}

	/**
	 * @param $tag
	 *
	 * @return string
	 */
	protected static function tagFilter($tag)
	{
		return trim(strip_tags($tag));
	}
}