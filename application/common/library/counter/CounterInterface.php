<?php

namespace app\library\counter;

/**
 * CounterInterface is the interface that must be implemented by counter classes.   
 * 
 * @author DuyAnh
 *
 */
interface CounterInterface extends \Countable 
{
	/**
	 * Increase counter with input amount.
	 * We can decrease with negative value
	 * 
	 * @param number $amount (default is 1) 
	 */
	public function increase($amount = 1);
	
	/**
	 * Count elements of an object
	 * {@inheritDoc}
	 * @see Countable::count()
	 */
	public function count();	
	
	/**
	 * Save/export counter value to storage	
	 */
	public function save();
}