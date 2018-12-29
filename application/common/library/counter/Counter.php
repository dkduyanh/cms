<?php

namespace app\library\counter;

use Yii;

/**
 * Counter is the abstract class that must be extends by counter classes,
 * which has responsibility for fast displaying or increasing/decreasing counts of an object (such as number of comments, hits...).  
 * 
 * @author DuyAnh
 *
 */
abstract class Counter implements CounterInterface
{
	/**
	 * The unique string ID of counter. 
	 * In case of using more than one counter, we have to provide the difference ID so that they do not interfere with each other.
	 * @var string
	 */
	protected $counterId;
	
	/**
	 * The id of counter object 
	 * @var string|integer
	 */
	protected $key;
	
	/**
	 * The unique hash key generated from $counterId and $key
	 * This key is used for determine counter from temporary storage, so that it should be unique globally in the whole temporary storage.
	 * @var unknown
	 */
	protected $hashKey;
	
	/**
	 * The number of seconds in which the counter will expire in temporary storage. (0 means never expire)
	 * TODO: fix risk of data loss because of cache expriation before threshold
	 * @var integer
	 */
	protected $expire = 0;
	
	/**
	 * Indicates how often should the count value be saved from temporary storage to permanent storage. 
	 * Defaults to 100, meaning the save() method will be invoked once every 100 counts. 
	 * Small threshold will help to reduce the risk of losing some counts if temporary storage was reset but may affect to permament storage
	 * However, if the count value is always smaller than threshold, it will never be saved (save()) to permanent storage. 
	 * So, to prevent lose data, we have to call the save() manually or set an automatic scheduler (such as cronjob) to do it.
	 * If you want to save() a mass of counters, please use saveAl() function
	 * 
	 * @var integer
	 */	
	protected $threshold = 100;
	
	/**
	 * The temporary storage instance
	 * it should be the Cache connection object such as Memcache, Redis, File...
	 * @var object
	 */
	protected $cacheStorage;
	
	/**
	 * Counter should is kept in a group stored in temporary storage
	 * @var integer
	 */
	const TOTAL_LISTS = 100;
	
	/**
	 * Constructor
	 * @param string $counterId
	 * @param int|string $key
	 * @param array $args ['expire', 'threshold']
	 * @throws \ErrorException
	 */
	public function __construct($counterId, $key, array $args = []){
		$this->key = $key;
		$this->counterId = $counterId;
		$this->expire = isset($args['expire'])?$args['expire']:$this->expire;
		$this->threshold = isset($args['threshold'])?$args['threshold']:$this->threshold;
		
		//validate input params
		if(!isset($this->counterId) || !is_string($this->counterId)) 
			throw new \ErrorException("Invalid counter id");
		if(!isset($this->key)) 
			throw new \ErrorException("Invalid key");
		if(!isset($this->expire) || !is_int($this->expire))  
			throw new \ErrorException("Invalid expiration value");
		if(!isset($this->threshold) || !is_int($this->threshold) || $this->threshold < 0)
			throw new \ErrorException("Invalid threshold value");
		
		//create hash key for temporary storage
		$this->hashKey = $this->generateHashKey($this->counterId, $this->key);
		
		//init temporaray storage instance
		$this->cacheStorage = Yii::$app->cache;
	}
	
	/**
	 * Initialize counter with default value or load from permanent storage (database)
	 * @return int the initial value of counter
	 */
	abstract protected function init();
	
	/**
	 * Save/export counter to database
	 * @return bool
	 */
	abstract public function save();
	
	/**
	 * Increase counter with input amount.
	 * We can decrease with negative value
	 * @param number $amount
	 * @return int the increasing number 
	 */
	public function increase($amount = 1){
		//increase counter
		$count = $this->get() + (int)$amount;
		
		//TODO: CHECK IF COUNTER IS EQUAL 0 OR NEGATIVE
		
		//save to cache
		$this->set($count);
		//save to db when reach threashold
		if(($count % $this->threshold) == 0){
			$this->save();
		}
		return $count;
	}
	
	/**
	 * Decrease counter with input amount.
	 * It is equivalent to increase with a negative amount. increase($amount*-1);
	 * @param unknown $amount
	 * @return number
	 */
	public function decrease($amount = 1)
	{
		$amount = (int)$amount * -1;
		return $this->increase($amount);	
	}
	
	/**
	 * An alias of function get()
	 * {@inheritDoc}
	 * @see Countable::count()
	 */
	public function count(){
		return $this->get();
	}
	
	/**
	 * Get/Return the counter value from temporary storage
	 * The init() will be execute if we get() the counter which is not found (does not exist) or deleted from temporary storage.
	 * @return int the current count number
	 */
	public function get(){
		//get counter from cache
		$count = $this->cacheStorage->get($this->hashKey);
		//initialize counter if does not exist
		if($count === false){
			$count = $this->init();
			$this->set($count);
		}
		return $count;
	}
	
	/**
	 * Set counter value to temporary storage (cache)
	 * If counter from temporary storage does not exist, try to create a new one
	 * @return bool
	 */
	protected function set($value){
		if($this->cacheStorage->set($this->hashKey, $value, $this->expire)){
			return $this->addToList();
		}
		return false;
	}
	
	/**
	 * Delete/Clear/Reset counter from temporary storage (cache).
	 * BE CAREFUL!!! 
	 * 	- Unless you want to reset, never call this function before save() because the value from temporary storage will be lost!
	 * 		-> For safe deleting, this function should be executed after the save() function to make sure data is writen to permanent storage.
	 *  - In some cases, if there is no update for a long time (when greater than $expire) or the value is never greater than $threshold, 
	 *      the counter from temporary storage may be automatically expired before save() function which also causes data loss
	 * 
	 * @return bool
	 */
	protected function delete(){
		if($this->cacheStorage->delete($this->hashKey)){
			return $this->removeFromList();
		}
		return false;
	}
	
	/**
	 * An alias of function delete()
	 * {@inheritDoc}
	 * @see Countable::count()
	 */
	protected function reset(){
		return $this->delete();
	}
	
	/**
	 * Generate hash key of this counter
	 * @return string The hash key generated from $counterId and $key
	 */
	private function generateHashKey(){
		return md5($this->counterId.'_ID_'.$this->key);
	}
	
	private function generateListId(){
		return abs(crc32($this->hashKey)) % static::TOTAL_LISTS;
	}
	
	/**
	 * Generate list id of this counter
	 * @param unknown $key
	 */
	private function generateHashListKey($listId){
		return md5($this->counterId.'_GROUP_'.$listId);
	}
	
	protected function getCounterLists()
	{
		$arrHashListKey = [];
		for($i = 0; $i < static::TOTAL_LISTS; $i++){
			$arrHashListKey[] = $this->generateHashListKey($i);
		}
		return $arrHashListKey;
	}
	
	/**
	 * Add counter to a list in temporary storage
	 * @return bool
	 */
	private function addToList()
	{
		//get counters from list
		$listKey = self::generateHashListKey($this->generateListId());
		$listData = $this->cacheStorage->get($listKey);
		
		//create list if does not exist
		if($listData === false){
			$listData = array();
		}
		
		//check if this counter has already in list?
		if(!isset($listData[$this->key]))
		{
			//add counter to list
			$listData[$this->key] = $this->hashKey;
			//update list
			return $this->cacheStorage->set($listKey, $listData, 0); 
		}
		return false;
	}
	
	/**
	 * Remove counter from list in temporary storage
	 * @return bool
	 */
	private function removeFromList()
	{
		//get counters from list
		$listKey = self::generateHashListKey($this->generateListId());
		$listData = $this->cacheStorage->get($listKey);
		
		//check if this counter has already in list?
		if($listData !== false && isset($listData[$this->key])){
			//delete this counter from list
			unset($listData[$this->key]);
			//update list
			return $this->cacheStorage->set($listKey, $listData, 0); 
		}
		return false;		
	}

	/**
	 * Save all counters to permanent storage. 
	 * This function should be executed in background.
	 * 
	 * 
	 * @return bool
	 */
	public function saveAll(){
		$arrCounterLists = $this->getCounterLists();
		foreach($arrCounterLists as $listKey){
			$listData = $this->cacheStorage->get($listKey);
			//destroy group data
			if($listData !== false){
				foreach($listData as $id => $hashKey){
					$counter = new self($id);
					$counter->save();
				}
			}
			//destroy group
			$this->cacheStorage->delete($listKey);
		}
		return true;
	}
}