<?php
namespace common\library;

class Utils {
	//const MD5_HASH = 'md5';

	/**
	 * Check if the string is serialized.
	 *
	 * @param $str The string to check if was serialized.
	 * @param bool $strict Optional. Whether to be strict about the end of the string. Default true.
	 * @return bool False if not serialized and true if it was.
	 * @author Wordpress
	 */
	public static function isSerialized($str, $strict = true)
	{
		// if it isn't a string, it isn't serialized.
		if ( ! is_string( $str ) ) {
			return false;
		}
		$str = trim( $str );
		if ( 'N;' == $str ) {
			return true;
		}
		if ( strlen( $str ) < 4 ) {
			return false;
		}
		if ( ':' !== $str[1] ) {
			return false;
		}
		if ( $strict ) {
			$lastc = substr( $str, -1 );
			if ( ';' !== $lastc && '}' !== $lastc ) {
				return false;
			}
		} else {
			$semicolon = strpos( $str, ';' );
			$brace     = strpos( $str, '}' );
			// Either ; or } must exist.
			if ( false === $semicolon && false === $brace )
				return false;
			// But neither must be in the first X characters.
			if ( false !== $semicolon && $semicolon < 3 )
				return false;
			if ( false !== $brace && $brace < 4 )
				return false;
		}
		$token = $str[0];
		switch ( $token ) {
			case 's' :
				if ( $strict ) {
					if ( '"' !== substr( $str, -2, 1 ) ) {
						return false;
					}
				} elseif ( false === strpos( $str, '"' ) ) {
					return false;
				}
			// or else fall through
			case 'a' :
			case 'O' :
				return (bool) preg_match( "/^{$token}:[0-9]+:/s", $str );
			case 'b' :
			case 'i' :
			case 'd' :
				$end = $strict ? '$' : '';
				return (bool) preg_match( "/^{$token}:[0-9.E-]+;$end/", $str );
		}
		return false;
	}

	/**
	 * Hàm chuyển đổi ngày tháng
	 * @param string $date: ngày tháng muốn chuyển đổi
	 * @param string $source: định dạng ngày hiện tại
	 * @param string $to: định đạng ngày tháng muốn chuyển thành
	 * @return unknown|string
	 */
	public static function formatDate($date, $source = 'd/m/Y', $to = 'Y-m-d')
	{
		if(self::isValidDateFormat($date, $source)){
			return \DateTime::createFromFormat($source, $date)->format($to);
		}
		return '';
	}
	
	/**
	 * Check if the current date is right format
	 * @param string $date
	 * @param string $format
	 * @return boolean
	 */
	public static function isValidDateFormat($date, $format = 'Y-m-d')
	{
		$d = \DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) === $date;
	}
	
	/**
	 * Checking is windows family OS
	 * @return boolean return true if script running under windows OS
	 */
	protected function isWindowsOS(){
		return strncmp(PHP_OS, 'WIN', 3) === 0;
	}
	
	/**
	 * Removes unicode text and tries to replace it in US-ASCII characters. 
	 * It's also used to clean file names during upload by replacing unwanted characters.
	 * @param String $text input text
	 * @return String
	 */
	public static function transliterate($text){
		$text = preg_replace("/[ạáàảãâậấầẩẫăặắằẳẫäå]/u","a",$text);
		$text = preg_replace("/[ẠÁÀẢÃÂẬẤẦẨẪĂẮẰẲẴẶÄÅ]/u","A",$text);
		$text = preg_replace("/[æ]/u", "ae", $text);
		$text = preg_replace("/[Æ]/u", "AE", $text);		
		$text = preg_replace("/[þ]/u","b",$text);
		$text = preg_replace("/[Þ]/u","B",$text);
		$text = preg_replace("/[ç]/u","c",$text);
		$text = preg_replace("/[Ç]/u","C",$text);
		$text = preg_replace("/[đð]/u","d",$text);
		$text = preg_replace("/[Đ]/u","D",$text);
		$text = preg_replace("/[ẹéèẻẽêếềểễệë]/u","e",$text);
		$text = preg_replace("/[ẸÉÈẺẼÊẾỀỂỄỆË]/u","E",$text);
		$text = preg_replace("/[ịíìỉĩîï]/u","i",$text);
		$text = preg_replace("/[ỊÍÌỈĨÎÏ]/u","I",$text);
		$text = preg_replace("/[ñ]/u","n",$text);
		$text = preg_replace("/[Ñ]/u","N",$text);
		$text = preg_replace("/[óòỏõọôốồổỗộơớờởỡợöøº]/u","o",$text);
		$text = preg_replace("/[ÓÒỎÕỌÔỐỒỔỖỘƠỚỜỞỠỢÖØ]/u","O",$text);
		$text = preg_replace("/[úùủũụưứừửữựûüµ]/u","u",$text);
		$text = preg_replace("/[ÚÙỦŨỤƯỨỪỬỮỰÛÜ]/u","U",$text);
		$text = preg_replace("/[ŕ]/u","r",$text);
		$text = preg_replace("/[Ŕ]/u","R",$text);
		$text = preg_replace("/[š]/u","s",$text);
		$text = preg_replace("/[Š]/u","S",$text);
		$text = preg_replace("/[ýỳỷỹỵŷÿ]/u","y",$text);
		$text = preg_replace("/[ÝỲỶỸỴŶŸ]/u","Y",$text);
		$text = preg_replace("/[ž]/u","z",$text);
		$text = preg_replace("/[Ž]/u","Z",$text);
		return preg_replace('/[^a-z0-9\s]/i', '', iconv("UTF-8", "UTF-8//TRANSLIT", $text));
		//return preg_replace('/[^a-z0-9\s]/i', '', iconv("UTF-8", "US-ASCII//TRANSLIT", $text));
	}
	
	public static function uri_encode($text, $length=0){
		$text = preg_replace('/(-{2,})|(\.{2,})+/', '-', strtolower(trim(preg_replace('/[^\w.]|[|_]+/', '-', self::transliterate($text)), '-')));
		if(is_int($length) && $length > 0 && mb_strlen($text, "UTF-8") > $length) 
		{
			$text = mb_substr($text, 0, $length, "UTF-8");
		}
		return urlencode($text);
		//Read more: http://msdn.microsoft.com/en-us/library/az24scfc.aspx
		//return $text = strtolower(trim(preg_replace('/[\W|_]+/','-',self::latin1_to_ascii($texting)),'-'));
	}
	
	public static function utf8_to_ncrdecimal($str) {
		return preg_replace("/([\\xC0-\\xF7]{1,1}[\\x80-\\xBF]+)/e", 'self::_utf8_to_ncrdecimal("\\1")', $str);
	}
	
	private static function _utf8_to_ncrdecimal($str) {
		$ret = 0;
		foreach( (str_split(strrev(chr((ord($str{0}) % 252 % 248 % 240 % 224 % 192) + 128) . substr($str, 1)))) as $k => $v)
			$ret += (ord($v) % 128) * pow(64, $k);
			return "&#$ret;";
	}
	
	/**
	 * Converts text from NRC Decimal to UTF-8
	 * @param String $text input string in NRC Decimal format
	 * @return String String in UTF-8 format
	 */
	public static function nrcdecimal_to_utf8($text) {
		return html_entity_decode($text,ENT_NOQUOTES,'UTF-8');
	}
	
	/**
	 * Checks if if a string starts with the specified needle
	 * @param String $haystack The input string
	 * @param String $needle The string which is at the beginning of haystack
	 * @return boolean
	 */
	public static function startsWith($haystack, $needle) {
		return strncmp($haystack, $needle, strlen($needle)) === 0;
	
		// search backwards starting from haystack length characters from the end
		//return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
	}
	
	/**
	 * Checks if a string ends with the specified needle
	 * @param String $haystack The input string
	 * @param String $needle The string which is the end of haystack
	 * @return boolean
	 */
	public static function endsWith($haystack, $needle) {
		return $needle === '' || substr_compare($haystack, $needle, -strlen($needle)) === 0;
	
		// search forward starting from end minus needle length characters
		//return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
	}
	
	/**
	 * Convert BR tags to newlines and carriage returns.
	 *
	 * @param string The string to convert
	 * @param string The string to use as line separator
	 * @return string The converted string
	 */
	public static function br2nl($string, $separator = PHP_EOL )
	{
		$separator = in_array($separator, array("\n", "\r", "\r\n", "\n\r", chr(30), chr(155), PHP_EOL)) ? $separator : PHP_EOL;  // Checks if provided $separator is valid.
		return preg_replace('/\<br(\s*)?\/?\>/i', $separator, $string);
	}	
	
	/**
	 * Truncates a string to a certain length if necessary
	 * @param String $text input string
	 * @param int $length length of truncated text
	 * @param String $etc end string
	 * @param String $charset charset of input string
	 * @return String truncated string
	 */
	public static function truncate($text, $length, $etc="...", $charset = 'UTF-8'){
		if($length == 0) {
			return '';
		}
		if (mb_strlen($text, $charset) > $length) {
			$length -= min($length, mb_strlen($etc, $charset));
			$text = preg_replace('/\s+?(\S+)?$/', $etc, mb_substr($text, 0, (int)$length + 1, $charset));	
		}
		return $text;
	}
	
	/**
	 * Search and highlight keywords in a string
	 * @param String $text input text
	 * @param String $words words need to be highlighted
	 * @param String $bgColor color hex code
	 * @return String returns html markup for words need to be highlighted in text 
	 */
	public static function highlight($text, $words, $bgColor="#FBFF76")
	{
		$splited_words = explode(" ", $words);
		foreach($splited_words as $word)
		{
			$text = preg_replace("|($word)|Ui" ,
					"<span style=\"background:".$bgColor.";\">$1</span>" , $text );
		}
		return $text;
	}
	
	/**
	 * Generates random strings with specified length
	 * @param number (Optional) $length The length of the string to generate (default: 5)
	 * @param string (Optional) $allowNumbers Whether to include  numbers (default: true)
	 * @param string (Optional) $allowLowercaseChars Whether to include lowercase characters (default: true)
	 * @param string (Optional) $allowUppercaseChars Whether to include uppercase characters (default: true)
	 * @param string (Optional) $allowSymbols Whether to include symbols (special characters) (default: true)
	 * @return String The random string.
	 */
	public static function getRandomString($length = 5, $allowNumbers = true, $allowLowercaseChars = true, $allowUppercaseChars = true, $allowSymbols = true){
		$length = intval($length);
		$chars = '';
		
		if($allowNumbers){
			$chars .= '0123456789';
		}
		if($allowLowercaseChars){
			$chars .= 'abcdefghijklmnopqrstuvwxyz';
		}
		if($allowUppercaseChars){
			$chars .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		}
		if($allowSymbols){
			$chars .= '!@#$%^&*()[]{}<>.,+-_/\|`~?;:';
		}
		
		//Randomly shuffles characters
		$chars = str_split(str_shuffle($chars));
		
		$str = '';
		$max = count($chars) - 1;		
		for ($i=0; $i < $length; $i++){
			$str .= $chars[mt_rand(0, $max)];
		}
		return $str;
	}
	
	function passwordStrength($password)
	{
		$score = 0;
		$length = strlen($password);
		$upper = preg_match_all('/[A-Z]/', $password);
		$lower = preg_match_all('/[a-z]/', $password);
		$number = preg_match_all('/[0-9]/', $password);
		$symbols = preg_match_all('/[^a-zA-Z0-9]/', $password);
		
		$lettersOnly = preg_match_all('/[a-zA-Z]/', $password);
		if($length != $lettersOnly) $lettersOnly = 0;
		
		$numbersOnly = is_numeric($password) ? $length : 0;
		
		$repeat = 0;		
		foreach (count_chars($password, 1) as $i => $val) {
			if($val > 1) $repeat += $val;
			
		}
		
		$consecutiveLetters = 0;
		foreach(str_split($password) as $i => $val){
			if(isset($char) && $char == $val) $consecutiveLetters++;
			$char = $val;
		}
					
		/***** Additions *****/
		//Number of Characters ==> +(n*4)
		$score += $length * 4;		
		//Uppercase Letters ==> +((len-n)*2)
		if($upper) $score += (($length-$upper)*2);		
		//Lowercase Letters ==> +((len-n)*2)
		if($lower) $score += (($length-$lower)*2);		
		//Numbers ==> +(n*4)
		if($number) $score += ($number*4);
		//Symbols ==> +(n*6)
		if($symbols) $score += ($symbols*6);
		
		
		/***** Deductions *****/
		//Letters Only ==> -n
		$score += -$lettersOnly;
		//Numbers Only ==> -n
		$score += -$numbersOnly;
		//Repeat Characters (Case Insensitive)
		$score += $repeat;
		//Consecutive Letters ==> -(n*2)
		$score += -($consecutiveLetters*2);
		
		if($score > 100) $score = 100;
		return $score;
	}
	
	/**
	 * Gets query strings
	 * @param String $url A valid URL string
	 * @return mixed Returns FALSE if url is invalid, 
	 * 				 Returns NULL if the query string doesn't exist within the given URL, 
	 * 				 Returns array [] if the query string was found
	 * @example Utils::getQueryStrings('http://www.example.com/path?googleguy=googley&test=true');
	 * 
	 */
	public static function getQueryStrings($url){
		//check if is valid url
		if(!filter_var($url, FILTER_VALIDATE_URL)) return false;	
		//parse string and return value
		$q = parse_url($url, PHP_URL_QUERY);
		if($q !== null){
			parse_str($q, $q);
		}
		return $q;		
	}
	
	/**
	 * Rebuild URL with new query strings
	 * @param String $url A valid URL string
	 * @param array $arrQueryStrings List of query strings
	 * 
	 */
	public static function buildUrlWithQueryStrings($url, array $arrQueryStrings){
		//check if is valid url
		if(!filter_var($url, FILTER_VALIDATE_URL)) return false;
		$parts = parse_url($url);
		if ($parts)
		{
			/*
			//This function http_build_url doesn't work anymore on PHP 5
			$url = http_build_url($url,[
					"scheme" => $parts['scheme'],
					"host"   => $parts['host'],
					"path"   => $parts['path'],
					"query"  => http_build_query($arrQueryStrings)
			]);*/
			//remove old query strings
			$url = sprintf('%s://%s%s', $parts['scheme'], $parts['host'], $parts['path']);
			if(($q = http_build_query($arrQueryStrings))){
				$url .= '?'.$q;
			}
		}
		return $url;
	}
	
	/**
	 * Gets current url
	 * @return String current http url
	 */
	public static function getCurrentUrl() {
		$url = "http://";
		if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
			$url = "https://";
		}
		if ($_SERVER["SERVER_PORT"] != "80") {
			$url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $url;
	}
	
	/**
	 * Gets client IP
	 * @return String IP v4
	 */
	public static function getClientIp() {
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	
	/**
	 * Generates a UUID v4 using PHP code (DRUPAL)
	 * @return String UUID
	 */
	public static function uuid()
	{
		$hex = substr(hash('sha256', Crypt::randomBytes(16)), 0, 32);
		
		// The field names refer to RFC 4122 section 4.1.2.
		$time_low = substr($hex, 0, 8);
		$time_mid = substr($hex, 8, 4);
		
		$time_hi_and_version = base_convert(substr($hex, 12, 4), 16, 10);
		$time_hi_and_version &= 0x0FFF;
		$time_hi_and_version |= (4 << 12);
		
		$clock_seq_hi_and_reserved = base_convert(substr($hex, 16, 4), 16, 10);
		$clock_seq_hi_and_reserved &= 0x3F;
		$clock_seq_hi_and_reserved |= 0x80;
		
		$clock_seq_low = substr($hex, 20, 2);
		$nodes = substr($hex, 20);
		
		$uuid = sprintf('%s-%s-%04x-%02x%02x-%s',$time_low, $time_mid, $time_hi_and_version, $clock_seq_hi_and_reserved,$clock_seq_low, $nodes);
		
		return $uuid;		
	}
	
	/**
	 * Geocoding is the process of finding associated geographic coordinates (often expressed as latitude and longitude) from other geographic data, such as street addresses, or ZIP codes (postal codes).
	 * @param String $address
	 * @throws \Exception
	 */
	public static function geocoding($address){
		//check if curl is installed?
		if(!in_array('curl', get_loaded_extensions())) {
			throw new \Exception('cURL is NOT installed on your server!');
		}
		$url = "http://maps.googleapis.com/maps/api/geocode/json?address=".str_replace (" ", "+", urlencode($address));
		//query google
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = json_decode(curl_exec($ch), true);
		// If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
		if ($response['status'] != 'OK') {
			return false;
		}
		$results = $response['results'];
		return array(
			'formatted_address' => $results[0]['formatted_address'],
			'latitude' => $results[0]['geometry']['location']['lat'],
			'longitude' => $results[0]['geometry']['location']['lng'],
			'location_type' => $results[0]['geometry']['location_type']
		); 
	}
	
	/**
     * Generates CSRF token.
     * @param String $namespace The session token name where the token will be retrieved. (It should be the same name with the hidden field name)
     * @param Integer $timeout Forces the token expire after $timeout seconds. (null = never)
	 * @return String The generated, base64 encoded token.
     */
	public static function generateToken($namespace, $timeout = 3600){
		if(!isset($_SESSION)) session_start();
		$token = md5(uniqid(rand(), true));
		$_SESSION['csrf'][$namespace] = array(
			'token' => $token,
			'expired' => time()+intval($timeout)
		);	
		return $token;
	}
	
	/**
     * Get CSRF token. [Wrong usage: generateToken('test') == getToken('test')]
     * @param String $namespace The session token name where the token will be retrieved.
	 * @return String The base64 encoded token or null.
     */
	public static function getToken($namespace, $generate = false){
		return isset($_SESSION['csrf'][$namespace]['token']) ? $_SESSION['csrf'][$namespace]['token'] : null;
	}
	
	/**
     * Checks if input CSRF token is valid. Make sure you generated a token in the form before checking it.
     * @param String $namespace The session token name where we retrieve the token.
     * @param String $token The input CSRF token.
	 * @param Boolean $ott (One-Time Token) TRUE to make the token reusable and not one-time. (Useful for ajax-heavy requests).
     * @param Boolean $exception TRUE to throw exception on check fail, FALSE or default to return false.
     * @return Boolean Returns FALSE if a CSRF attack is detected, TRUE otherwise.
     */
	public static function verifyToken($namespace, $token, $ott = true, $exception = false){
		/* check token expiration */
		if (!isset($_SESSION['csrf'][$namespace]) || !isset($_SESSION['csrf'][$namespace]['token']) || !isset($_SESSION['csrf'][$namespace]['expired'])){
			if($exception)
				throw new \Exception('Missing token.');
			else
				return false;
		}
		
		// Get valid token from session
		$hash = $_SESSION['csrf'][$namespace];

		//Free up session token for one-time token usage.
		if($ott){
			$_SESSION['csrf'][$namespace] = null;
		}
		
		//Check if session token matches form input token
		if($hash['token'] != $token){
			if($exception)
				throw new \Exception('Invalid token.');
			else
				return false;
		}
		
		//check if token is expired
		if($hash['expired'] !== null && $hash['expired'] < time()){
			if($exception)
				throw new \Exception('Token has expired.');
			else
				return false;
		}
		return true;
	}
		
	/**
     * Creates a new string hash
     * @param String $string The string need to be hashed.
     * @param String $method (optional, default md5) A password algorithm is used when hashing the password.
     * @return the hashed password, or FALSE on failure
     */
	public static function hashString($string, $salt = '')
	{
		if(!is_string($salt) || $salt == '')
		{
			$salt = self::getRandomString(8);
		}
		return $salt.md5($string.$salt);		
	}
		
	/**
     * Verifies that a string matches a hash. Make sure given hash and given string are generated by the same algorithm.
     * @param String $string The string need to be verified.
     * @param String $hash A hash created by hashString function.
	 * @param String $method (optional, default md5). The hasing algorithm is used when verify the password.
     * @return the hashed password, or FALSE on failure
     */
	public static function verifyHashedString($string, $hash)
	{
		// If the hash is still md5...
		$salt = substr($hash, 0, -32);
		$hashedString = substr($hash, -32);
		
		if (function_exists('hash_equals')) {
			//(PHP 5 >= 5.6.0, PHP 7) Prevent Timing attack
			return hash_equals($hashedString, md5($string.$salt));
		}
		return (md5($string.$salt) === $hashedString);
	}
	
	/**
	 * Gets hash file info
	 * @param String $filename URL describing location of file to be hashed; Supports fopen wrappers. 
	 * @param String $method Name of selected hashing algorithm (i.e. "md5", "sha1", "sha256", "sha512", etc..) - default is md5
	 * @return String a string containing the calculated message digest as lowercase hexits 
	 */
	public static function hashFile($filename, $method = 'sha256'){
		//check is file valid
		if(!is_file($filename)){
			return false;
		}
		if(! preg_match('#^[a-zA-Z0-9]+://#', $filename)){
			return hash_file($method, $filename);			
		}
		switch($method){
			case 'md5': //VERIFY PASSWORD BY USING MD5()
			{
				return md5_file($filename);
			}
			case 'sha1': //VERIFY PASSWORD BY USING PHPASS 
			{
				return sha1_file($filename);
			}
			default:
			{
				return hash_file($method, $filename);
			}
		}
	}
	
	/**
	 * Encrypts plaintext with given parameters. (Do not use this function to encrypt user's password)
	 * @param String $string The data that will be encrypted 
	 * @param String $key The key with which the data will be encrypted
	 * @return String The encrypted data, as a string
	 */
	public static function encrypt($string, $key)
	{
		if(function_exists('mcrypt_encrypt') && function_exists('mcrypt_create_iv') && function_exists('mcrypt_get_iv_size')){
			return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
		}
		else{
			$result = '';
			$strLen = strlen($string);
			$keyLen = strlen($key);
			for($i=0; $i<$strLen; $i++) {
				$char = substr($string, $i, 1);
				$keychar = substr($key, ($i % $keyLen)-1, 1);
				$char = chr(ord($char)+ord($keychar));
				$result .= $char;
			}
			return base64_encode($result);
		}
	}
	
	/**
	 * Decrypts crypttext with given parameters
	 * @param String $string The data that will be decrypted 
	 * @param String $key The key with which the data was encrypted
	 * @return String The decrypted data as a string
	 */
	public static function decrypt($string, $key)
	{
		if(function_exists('mcrypt_decrypt') && function_exists('mcrypt_create_iv') && function_exists('mcrypt_get_iv_size')){
			return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
		}
		else{
			$result = '';
			$string = base64_decode($string);
			for($i=0; $i<strlen($string); $i++) {
				$char = substr($string, $i, 1);
				$keychar = substr($key, ($i % strlen($key))-1, 1);
				$char = chr(ord($char)-ord($keychar));
				$result.=$char;
			}
			return $result;
		}
	}
	
	/*
		A time difference function that outputs the time passed in facebook's style: 1 day ago, or 4 months ago
		$result = nicetime("2009-03-04 17:45"); // 2 days ago
	*/
	/**
	 * 
	 * @param unknown $date
	 */
	public static function nicetime($date)
	{
		if(empty($date)) {
			return "";
		}
	   
		$periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		$lengths         = array("60","60","24","7","4.35","12","10");
	   
		$now             = time();
		$unix_date       = strtotime($date);
	   
		// check validity of date
		if(empty($unix_date)) {   
			return "Bad date";
		}
	
		// is it future date or past date
		if($now > $unix_date) {   
			$difference     = $now - $unix_date;
			$tense         = "ago";
		   
		} else {
			$difference     = $unix_date - $now;
			$tense         = "from now";
		}
	   
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}
	   
		$difference = round($difference);
	   
		if($difference != 1) {
			$periods[$j].= "s";
		}
	   
		return "$difference $periods[$j] {$tense}";
	}
	
	/**
	 * Returns GMT/UTC date/time
	 * @param string $format
	 * @return string|unknown
	 */
	public static function getUTC($format = 'Y-m-d H:i:s')
	{
		return gmdate($format);
		return date($format, time());;
	}
	
	/**
	 * Returns list of timezones supported by PHP
	 * @return string[]
	 */
	public static function getTimezones()
    {
    	//return $timezones = \DateTimeZone::listAbbreviations();
        return [
            "Pacific/Midway" => "(GMT-11:00) Midway Island, Samoa",
            "Etc/GMT+10" => "(GMT-10:00) Hawaii",
            "Pacific/Marquesas" => "(GMT-09:30) Marquesas Islands",
            "America/Anchorage" => "(GMT-09:00) Alaska",
            "America/Los_Angeles" => "(GMT-08:00) Pacific Time (US & Canada)",
            "America/Denver" => "(GMT-07:00) Mountain Time (US & Canada)",
            "America/Chihuahua" => "(GMT-07:00) Chihuahua, La Paz, Mazatlan",
            "America/Dawson_Creek" => "(GMT-07:00) Arizona",
            "America/Belize" => "(GMT-06:00) Saskatchewan, Central America",
            "America/Cancun" => "(GMT-06:00) Guadalajara, Mexico City, Monterrey",
            "Chile/EasterIsland" => "(GMT-06:00) Easter Island",
            "America/Chicago" => "(GMT-06:00) Central Time (US & Canada)",
            "America/New_York" => "(GMT-05:00) Eastern Time (US & Canada)",
            "America/Havana" => "(GMT-05:00) Cuba",
            "America/Bogota" => "(GMT-05:00) Bogota, Lima, Quito, Rio Branco",
            "America/Caracas" => "(GMT-04:30) Caracas",
            "America/Santiago" => "(GMT-04:00) Santiago",
            "America/La_Paz" => "(GMT-04:00) La Paz",
            "America/Campo_Grande" => "(GMT-04:00) Brazil",
            "America/Goose_Bay" => "(GMT-04:00) Atlantic Time (Goose Bay)",
            "America/Glace_Bay" => "(GMT-04:00) Atlantic Time (Canada)",
            "America/St_Johns" => "(GMT-03:30) Newfoundland",
            "America/Araguaina" => "(GMT-03:00) UTC-3",
            "America/Montevideo" => "(GMT-03:00) Montevideo",
            "America/Godthab" => "(GMT-03:00) Greenland",
            "America/Argentina/Buenos_Aires" => "(GMT-03:00) Buenos Aires",
            "America/Sao_Paulo" => "(GMT-03:00) Brasilia",
            "America/Noronha" => "(GMT-02:00) Mid-Atlantic",
            "Atlantic/Cape_Verde" => "(GMT-01:00) Cape Verde Is.",
            "Atlantic/Azores" => "(GMT-01:00) Azores",
            "Europe/London" => "(GMT) Greenwich Mean Time : London",
            "Africa/Abidjan" => "(GMT) Monrovia, Reykjavik",
            "Europe/Amsterdam" => "(GMT+01:00) Western & Central Europe",
            "Africa/Algiers" => "(GMT+01:00) West Central Africa",
            "Africa/Windhoek" => "(GMT+01:00) Windhoek",
            "Africa/Cairo" => "(GMT+02:00) Kiev, Cairo, Pretoria, Jerusalem",
            "Europe/Moscow" => "(GMT+03:00) Nairobi, Moscow",
            "Asia/Tehran" => "(GMT+03:30) Tehran",
            "Asia/Dubai" => "(GMT+04:00) Abu Dhabi, Muscat",
            "Asia/Yerevan" => "(GMT+04:00) Yerevan",
            "Asia/Kabul" => "(GMT+04:30) Kabul",
            "Asia/Tashkent" => "(GMT+05:00) Tashkent",
            "Asia/Kolkata" => "(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi",
            "Asia/Katmandu" => "(GMT+05:45) Kathmandu",
            "Asia/Dhaka" => "(GMT+06:00) Astana, Dhaka",
            "Asia/Novosibirsk" => "(GMT+06:00) Novosibirsk",
            "Asia/Rangoon" => "(GMT+06:30) Yangon (Rangoon)",
            "Asia/Bangkok" => "(GMT+07:00) Bangkok, Hanoi, Jakarta",
            "Asia/Hong_Kong" => "(GMT+08:00) Beijing, Hong Kong",
            "Asia/Irkutsk" => "(GMT+08:00) Irkutsk, Ulaan Bataar",
            "Australia/Eucla" => "(GMT+08:45) Eucla",
            "Asia/Tokyo" => "(GMT+09:00) Osaka, Sapporo, Tokyo",
            "Asia/Seoul" => "(GMT+09:00) Seoul",
            "Australia/Adelaide" => "(GMT+09:30) Adelaide",
            "Australia/Brisbane" => "(GMT+10:00) Brisbane",
            "Australia/Hobart" => "(GMT+10:00) Hobart",
            "Asia/Vladivostok" => "(GMT+10:00) Vladivostok",
            "Australia/Lord_Howe" => "(GMT+10:30) Lord Howe Island",
            "Etc/GMT-11" => "(GMT+11:00) Solomon Is., New Caledonia",
            "Pacific/Norfolk" => "(GMT+11:30) Norfolk Island",
            "Asia/Anadyr" => "(GMT+12:00) Anadyr, Kamchatka",
            "Pacific/Auckland" => "(GMT+12:00) Auckland, Wellington",

            "Etc/GMT-12" => "(GMT+12:00) Fiji, Kamchatka, Marshall Is.",
            "Pacific/Chatham" => "(GMT+12:45) Chatham Islands",
            "Pacific/Tongatapu" => "(GMT+13:00) Nuku'alofa",
            "Pacific/Kiritimati" => "(GMT+14:00) Kiritimati",        		
        ];
    }
	
    /**
     * Get list of mime types
     * @return string[]
     */
    public static function getMimeTypes(){
    	//echo mime_content_type('test.php');
    	return [
			// applications
			'ai'    => 'application/postscript',
			'eps'   => 'application/postscript',
			'exe'   => 'application/x-executable',
			'doc'   => 'application/msword',
			'dot'   => 'application/msword',
			'xls'   => 'application/vnd.ms-excel',
			'xlt'   => 'application/vnd.ms-excel',
			'xla'   => 'application/vnd.ms-excel',
			'ppt'   => 'application/vnd.ms-powerpoint',
			'pps'   => 'application/vnd.ms-powerpoint',
			'pdf'   => 'application/pdf',
			'xml'   => 'application/xml',
			'swf'   => 'application/x-shockwave-flash',
			'torrent' => 'application/x-bittorrent',
			'jar'   => 'application/x-jar',
			// open office (finfo detect as application/zip)
			'odt'   => 'application/vnd.oasis.opendocument.text',
			'ott'   => 'application/vnd.oasis.opendocument.text-template',
			'oth'   => 'application/vnd.oasis.opendocument.text-web',
			'odm'   => 'application/vnd.oasis.opendocument.text-master',
			'odg'   => 'application/vnd.oasis.opendocument.graphics',
			'otg'   => 'application/vnd.oasis.opendocument.graphics-template',
			'odp'   => 'application/vnd.oasis.opendocument.presentation',
			'otp'   => 'application/vnd.oasis.opendocument.presentation-template',
			'ods'   => 'application/vnd.oasis.opendocument.spreadsheet',
			'ots'   => 'application/vnd.oasis.opendocument.spreadsheet-template',
			'odc'   => 'application/vnd.oasis.opendocument.chart',
			'odf'   => 'application/vnd.oasis.opendocument.formula',
			'odb'   => 'application/vnd.oasis.opendocument.database',
			'odi'   => 'application/vnd.oasis.opendocument.image',
			'oxt'   => 'application/vnd.openofficeorg.extension',
			// MS office 2007 (finfo detect as application/zip)
			'docx'  => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'docm'  => 'application/vnd.ms-word.document.macroEnabled.12',
			'dotx'  => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
			'dotm'  => 'application/vnd.ms-word.template.macroEnabled.12',
			'xlsx'  => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			'xlsm'  => 'application/vnd.ms-excel.sheet.macroEnabled.12',
			'xltx'  => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
			'xltm'  => 'application/vnd.ms-excel.template.macroEnabled.12',
			'xlsb'  => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
			'xlam'  => 'application/vnd.ms-excel.addin.macroEnabled.12',
			'pptx'  => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
			'pptm'  => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
			'ppsx'  => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
			'ppsm'  => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
			'potx'  => 'application/vnd.openxmlformats-officedocument.presentationml.template',
			'potm'  => 'application/vnd.ms-powerpoint.template.macroEnabled.12',
			'ppam'  => 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
			'sldx'  => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
			'sldm'  => 'application/vnd.ms-powerpoint.slide.macroEnabled.12',
			// archives
			'gz'    => 'application/x-gzip',
			'tgz'   => 'application/x-gzip',
			'bz'    => 'application/x-bzip2',
			'bz2'   => 'application/x-bzip2',
			'tbz'   => 'application/x-bzip2',
			'xz'    => 'application/x-xz',
			'zip'   => 'application/zip',
			'rar'   => 'application/x-rar',
			'tar'   => 'application/x-tar',
			'7z'    => 'application/x-7z-compressed',
			// texts
			'txt'   => 'text/plain',
			'php'   => 'text/x-php',
			'html'  => 'text/html',
			'htm'   => 'text/html',
			'js'    => 'text/javascript',
			'css'   => 'text/css',
			'rtf'   => 'text/rtf',
			'rtfd'  => 'text/rtfd',
			'py'    => 'text/x-python',
			'java'  => 'text/x-java-source',
			'rb'    => 'text/x-ruby',
			'sh'    => 'text/x-shellscript',
			'pl'    => 'text/x-perl',
			//'xml'   => 'text/xml',
			'sql'   => 'text/x-sql',
			'c'     => 'text/x-csrc',
			'h'     => 'text/x-chdr',
			'cpp'   => 'text/x-c++src',
			'hh'    => 'text/x-c++hdr',
			'log'   => 'text/plain',
			'csv'   => 'text/csv',
			'md'    => 'text/x-markdown',
			'markdown' => 'text/x-markdown',
			// images
			'bmp'   => 'image/x-ms-bmp',
			'jpg'   => 'image/jpeg',
			'jpeg'  => 'image/jpeg',
			'gif'   => 'image/gif',
			'png'   => 'image/png',
			'tif'   => 'image/tiff',
			'tiff'  => 'image/tiff',
			'tga'   => 'image/x-targa',
			'psd'   => 'image/vnd.adobe.photoshop',
			//'ai'    => 'image/vnd.adobe.photoshop',
			'xbm'   => 'image/xbm',
			'pxm'   => 'image/pxm',
			//audio
			'mp3'   => 'audio/mpeg',
			'mid'   => 'audio/midi',
			'ogg'   => 'audio/ogg',
			'oga'   => 'audio/ogg',
			'm4a'   => 'audio/x-m4a',
			'wav'   => 'audio/wav',
			'wma'   => 'audio/x-ms-wma',
			// video
			'avi'   => 'video/x-msvideo',
			'dv'    => 'video/x-dv',
			'mp4'   => 'video/mp4',
			'mpeg'  => 'video/mpeg',
			'mpg'   => 'video/mpeg',
			'mov'   => 'video/quicktime',
			'wm'    => 'video/x-ms-wmv',
			'flv'   => 'video/x-flv',
			'mkv'   => 'video/x-matroska',
			'webm'  => 'video/webm',
			'ogv'   => 'video/ogg',
			'ogm'   => 'video/ogg',
    	];
    }

    /**
     * @return array
     */
	public static function getCountries()
	{
		return array(
			"AF" => "Afghanistan",
			"AX" => "Åland Islands",
			"AL" => "Albania",
			"DZ" => "Algeria",
			"AS" => "American Samoa",
			"AD" => "Andorra",
			"AO" => "Angola",
			"AI" => "Anguilla",
			"AQ" => "Antarctica",
			"AG" => "Antigua and Barbuda",
			"AR" => "Argentina",
			"AM" => "Armenia",
			"AW" => "Aruba",
			"AU" => "Australia",
			"AT" => "Austria",
			"AZ" => "Azerbaijan",
			"BS" => "Bahamas",
			"BH" => "Bahrain",
			"BD" => "Bangladesh",
			"BB" => "Barbados",
			"BY" => "Belarus",
			"BE" => "Belgium",
			"BZ" => "Belize",
			"BJ" => "Benin",
			"BM" => "Bermuda",
			"BT" => "Bhutan",
			"BO" => "Bolivia",
			"BA" => "Bosnia and Herzegovina",
			"BW" => "Botswana",
			"BV" => "Bouvet Island",
			"BR" => "Brazil",
			"IO" => "British Indian Ocean Territory",
			"BN" => "Brunei Darussalam",
			"BG" => "Bulgaria",
			"BF" => "Burkina Faso",
			"BI" => "Burundi",
			"KH" => "Cambodia",
			"CM" => "Cameroon",
			"CA" => "Canada",
			"CV" => "Cape Verde",
			"KY" => "Cayman Islands",
			"CF" => "Central African Republic",
			"TD" => "Chad",
			"CL" => "Chile",
			"CN" => "China",
			"CX" => "Christmas Island",
			"CC" => "Cocos (Keeling) Islands",
			"CO" => "Colombia",
			"KM" => "Comoros",
			"CG" => "Congo",
			"CD" => "Congo, The Democratic Republic of The",
			"CK" => "Cook Islands",
			"CR" => "Costa Rica",
			"CI" => "Cote D'ivoire",
			"HR" => "Croatia",
			"CU" => "Cuba",
			"CY" => "Cyprus",
			"CZ" => "Czech Republic",
			"DK" => "Denmark",
			"DJ" => "Djibouti",
			"DM" => "Dominica",
			"DO" => "Dominican Republic",
			"EC" => "Ecuador",
			"EG" => "Egypt",
			"SV" => "El Salvador",
			"GQ" => "Equatorial Guinea",
			"ER" => "Eritrea",
			"EE" => "Estonia",
			"ET" => "Ethiopia",
			"FK" => "Falkland Islands (Malvinas)",
			"FO" => "Faroe Islands",
			"FJ" => "Fiji",
			"FI" => "Finland",
			"FR" => "France",
			"GF" => "French Guiana",
			"PF" => "French Polynesia",
			"TF" => "French Southern Territories",
			"GA" => "Gabon",
			"GM" => "Gambia",
			"GE" => "Georgia",
			"DE" => "Germany",
			"GH" => "Ghana",
			"GI" => "Gibraltar",
			"GR" => "Greece",
			"GL" => "Greenland",
			"GD" => "Grenada",
			"GP" => "Guadeloupe",
			"GU" => "Guam",
			"GT" => "Guatemala",
			"GG" => "Guernsey",
			"GN" => "Guinea",
			"GW" => "Guinea-bissau",
			"GY" => "Guyana",
			"HT" => "Haiti",
			"HM" => "Heard Island and Mcdonald Islands",
			"VA" => "Holy See (Vatican City State)",
			"HN" => "Honduras",
			"HK" => "Hong Kong",
			"HU" => "Hungary",
			"IS" => "Iceland",
			"IN" => "India",
			"ID" => "Indonesia",
			"IR" => "Iran, Islamic Republic of",
			"IQ" => "Iraq",
			"IE" => "Ireland",
			"IM" => "Isle of Man",
			"IL" => "Israel",
			"IT" => "Italy",
			"JM" => "Jamaica",
			"JP" => "Japan",
			"JE" => "Jersey",
			"JO" => "Jordan",
			"KZ" => "Kazakhstan",
			"KE" => "Kenya",
			"KI" => "Kiribati",
			"KP" => "Korea, Democratic People's Republic of",
			"KR" => "Korea, Republic of",
			"KW" => "Kuwait",
			"KG" => "Kyrgyzstan",
			"LA" => "Lao People's Democratic Republic",
			"LV" => "Latvia",
			"LB" => "Lebanon",
			"LS" => "Lesotho",
			"LR" => "Liberia",
			"LY" => "Libyan Arab Jamahiriya",
			"LI" => "Liechtenstein",
			"LT" => "Lithuania",
			"LU" => "Luxembourg",
			"MO" => "Macao",
			"MK" => "Macedonia, The Former Yugoslav Republic of",
			"MG" => "Madagascar",
			"MW" => "Malawi",
			"MY" => "Malaysia",
			"MV" => "Maldives",
			"ML" => "Mali",
			"MT" => "Malta",
			"MH" => "Marshall Islands",
			"MQ" => "Martinique",
			"MR" => "Mauritania",
			"MU" => "Mauritius",
			"YT" => "Mayotte",
			"MX" => "Mexico",
			"FM" => "Micronesia, Federated States of",
			"MD" => "Moldova, Republic of",
			"MC" => "Monaco",
			"MN" => "Mongolia",
			"ME" => "Montenegro",
			"MS" => "Montserrat",
			"MA" => "Morocco",
			"MZ" => "Mozambique",
			"MM" => "Myanmar",
			"NA" => "Namibia",
			"NR" => "Nauru",
			"NP" => "Nepal",
			"NL" => "Netherlands",
			"AN" => "Netherlands Antilles",
			"NC" => "New Caledonia",
			"NZ" => "New Zealand",
			"NI" => "Nicaragua",
			"NE" => "Niger",
			"NG" => "Nigeria",
			"NU" => "Niue",
			"NF" => "Norfolk Island",
			"MP" => "Northern Mariana Islands",
			"NO" => "Norway",
			"OM" => "Oman",
			"PK" => "Pakistan",
			"PW" => "Palau",
			"PS" => "Palestinian Territory, Occupied",
			"PA" => "Panama",
			"PG" => "Papua New Guinea",
			"PY" => "Paraguay",
			"PE" => "Peru",
			"PH" => "Philippines",
			"PN" => "Pitcairn",
			"PL" => "Poland",
			"PT" => "Portugal",
			"PR" => "Puerto Rico",
			"QA" => "Qatar",
			"RE" => "Reunion",
			"RO" => "Romania",
			"RU" => "Russian Federation",
			"RW" => "Rwanda",
			"SH" => "Saint Helena",
			"KN" => "Saint Kitts and Nevis",
			"LC" => "Saint Lucia",
			"PM" => "Saint Pierre and Miquelon",
			"VC" => "Saint Vincent and The Grenadines",
			"WS" => "Samoa",
			"SM" => "San Marino",
			"ST" => "Sao Tome and Principe",
			"SA" => "Saudi Arabia",
			"SN" => "Senegal",
			"RS" => "Serbia",
			"SC" => "Seychelles",
			"SL" => "Sierra Leone",
			"SG" => "Singapore",
			"SK" => "Slovakia",
			"SI" => "Slovenia",
			"SB" => "Solomon Islands",
			"SO" => "Somalia",
			"ZA" => "South Africa",
			"GS" => "South Georgia and The South Sandwich Islands",
			"ES" => "Spain",
			"LK" => "Sri Lanka",
			"SD" => "Sudan",
			"SR" => "Suriname",
			"SJ" => "Svalbard and Jan Mayen",
			"SZ" => "Swaziland",
			"SE" => "Sweden",
			"CH" => "Switzerland",
			"SY" => "Syrian Arab Republic",
			"TW" => "Taiwan, Province of China",
			"TJ" => "Tajikistan",
			"TZ" => "Tanzania, United Republic of",
			"TH" => "Thailand",
			"TL" => "Timor-leste",
			"TG" => "Togo",
			"TK" => "Tokelau",
			"TO" => "Tonga",
			"TT" => "Trinidad and Tobago",
			"TN" => "Tunisia",
			"TR" => "Turkey",
			"TM" => "Turkmenistan",
			"TC" => "Turks and Caicos Islands",
			"TV" => "Tuvalu",
			"UG" => "Uganda",
			"UA" => "Ukraine",
			"AE" => "United Arab Emirates",
			"GB" => "United Kingdom",
			"US" => "United States",
			"UM" => "United States Minor Outlying Islands",
			"UY" => "Uruguay",
			"UZ" => "Uzbekistan",
			"VU" => "Vanuatu",
			"VE" => "Venezuela",
			"VN" => "Viet Nam",
			"VG" => "Virgin Islands, British",
			"VI" => "Virgin Islands, U.S.",
			"WF" => "Wallis and Futuna",
			"EH" => "Western Sahara",
			"YE" => "Yemen",
			"ZM" => "Zambia",
			"ZW" => "Zimbabwe"
		);   
	}

    /**
     * @return array
     */
	public static function getLanguages()
    {
        $ret = array();
        foreach(self::getLocales() as $locale){
            $ret[$locale] = \Locale::getDisplayLanguage($locale);
        }
        return $ret;
    }

    public static function getCountries1()
    {
        $ret = array();
        foreach(self::getLocales() as $locale){
            $ret[$locale] = \Locale::getDisplayRegion($locale);
        }
        return $ret;
    }

    /**
     * Get list of locales
     * @return array
     */
    public static function getLocales()
    {
        return \ResourceBundle::getLocales('');
    }

    public static function getLocalesWithDisplayName()
    {
        $ret = array();
        foreach(self::getLocales() as $locale){
            $ret[$locale] = \Locale::getDisplayName($locale);
        }
        return $ret;
    }
}