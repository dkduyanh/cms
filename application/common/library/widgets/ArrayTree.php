<?php

namespace app\library\widgets;

use yii\helpers\Html;

/**
 * Class ArrayTree
 * 
 * Displays array models in tree view.
 * 
 * @author DuyAnh
 *
 */
class ArrayTree extends \yii\base\Widget
{
	/**
	 * @var string primary key
	 */
	public $id = 'id';
	
	/**
	 * @var string parent id
	 */
	public $parent_id = 'parent_id';
	
	/**
	 * @var string children
	 */
	public $children = 'children';
	
	/**
	 * @var array models
	 */
	public $models = [];
	
	/**
	 * @var string callback function for disply content of each item. Have $model argument.
	 */
	public $value = '';
	
	/**
	 * @var array container html options
	 */
	public $containerOptions = [];
	
	/**
	 * @var bool container options already set or not
	 */
	private $containerOptionsIsSet = false;
	
	/**
	 * Run the widget
	 * @return string tree
	 */
	public function run()
	{
		return $this->renderTree($this->createTreeArray());
	}
	
	/**
	 * Create tree array from models.
	 * @return array tree array
	 */
	private function createTreeArray()
	{
		$rows = [];
		foreach($this->models as $model) {
			$rows[] = [
				'id' => $model[$this->id],
				'parent_id' => $model[$this->parent_id],
				'model' => $model,
			];
		}
		return $rows;
	}
	
	/**
	 * Check node for child.
	 * @param array $rows
	 * @param int $id parent id
	 * @return bool
	 */
	private function hasChildren($rows, $id)
	{
		foreach ($rows as $row) {
			if (isset($row[$this->parent_id]) && $row[$this->parent_id] == $id) {
				return true;
			}
		}
		return false;
	}
	

	private function buildTree($rows, $parent_id = 0, $level = 0)
	{
		$tree = [];
		foreach ($rows as $row) {
			if ($row[$this->parent_id] == $parent_id) {
				$row['model']['level'] = $level;
				if ($this->hasChildren($rows, $row[$this->id])) {
					$row['model'][$this->children] = $this->buildTree($rows, $row[$this->id], ++$level);
				}
				$tree[] = $row['model'];
			}
		}
		return $tree;
	}
	
	 /**
     * Create tree.
     * @param array $rows
     * @param int $parent_id
     * @return string tree
     */
	protected function renderTree($rows, $parent_id = 0)
	{
		$containerAttributes = '';
		if (!$this->containerOptionsIsSet) {
			$containerAttributes = Html::renderTagAttributes($this->containerOptions);
			$this->containerOptionsIsSet = true;
		}
		$result = "<ul$containerAttributes>";
		foreach ($rows as $row) {
			if ($row['parent_id'] == $parent_id) {
				$value = call_user_func_array($this->value, ['model' => $row['model']]);
				$result .= "<li>$value";
				if ($this->hasChildren($rows, $row['id'])) {
					$result.= $this->renderTree($rows, $row['id']);
				}
				$result .= '</li>';
			}
		}
		$result .= '</ul>';
		return $result;
	}
}