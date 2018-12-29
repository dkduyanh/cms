<?php

namespace common\library\utils;

use yii\db\Exception;

class ArrayTreeBuilder
{
	/**
	 * @var string primary key
	 */
	protected $id = 'id';
	
	/**
	 * @var string parent id
	 */
	protected $parent_id = 'parent_id';
	
	/**
	 * @var string children
	 */
	protected $children = 'children';
	
	/**
	 * @var string
	 */
	protected $level = 'level';
	
	/**
	 * @var array data
	 */
	protected $data = [];
	
	/**
	 * Construtor
	 * @param mixed $data Data need to be built the tree
	 * @param array $options Change the value of other properties except $data
	 * @throws Exception
	 */
	public function __construct($data, $options = [])
	{		
		foreach($options as $opt => $value){
		    if(!property_exists($this, $opt)){
		        throw new Exception("Unknown property '{$opt}'");
            }
		    $this->$opt = $value;
        }
        $this->data = $data;
	}	
	
	/**
	 * Check node for child.
	 * @param int $id parent id
	 * @return bool
	 */
	protected function hasChildren($parent_id)
	{
		foreach($this->data as $row) {
			if($row[$this->parent_id] == $parent_id) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * 
	 * @param unknown $data
	 * @param number $parent_id
	 * @param number $level
	 * @return unknown[][]
	 */
	private function _buildTree($data, $deep, $parent_id = 0, $level = 0)
	{
		$tree = [];
		foreach($data as $key => $row) {
			if($level >= $deep) continue;
			if($row[$this->parent_id] == $parent_id) {
				//increase performance by removing checked item
				unset($data[$key]);
				
				$row[$this->level] = $level;
				if($this->hasChildren($row[$this->id])) {
					$row[$this->children] = $this->_buildTree($data, $deep, $row[$this->id], $level+1);
				}
				$tree[] = $row;
			}
		}
		return $tree;
	}
	
	private function _buildFlatTree($data, $deep, $parent_id = 0, $level = 0)
	{
		$tree = [];
		foreach($data as $key => $row)
		{
			if($level >= $deep) continue;
			if($row[$this->parent_id] == $parent_id) {
				//increase performance by removing checked item
				unset($data[$key]);
				
				$row[$this->level] = $level;
				$tree[] = $row;
				if($this->hasChildren($row[$this->id])) {
					$childrens = $this->_buildFlatTree($data, $deep, $row[$this->id], $level+1);
					foreach($childrens as $child){
						$tree[] = $child;
					}
				}
			}			
		}
		return $tree;
	}
	
	/**
	 * 
	 * @param number $parent_id
	 * @param number $deep
	 */
	public function buildTree($parent_id = 0, $deep = 250)
	{
		return $this->_buildTree($this->data, $deep, $parent_id, 0);
	}
	
	/**
	 * 
	 * @param number $parent_id
	 * @param number $deep
	 * @return number[]|unknown[]
	 */
	public function buildFlatTree($parent_id = 0, $deep = 250)
	{
		return $this->_buildFlatTree($this->data, $deep, $parent_id, 0);
	}
}