<?php

namespace app\library\Utils;

class Validator {
	
	public static function isEmail($email){
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
	
}