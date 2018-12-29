<?php
namespace frontend\config;

use Yii;
use yii\base\BootstrapInterface;
use backend\models\main\MenuItem;

class Bootstrap implements BootstrapInterface
{
	public function bootstrap($app)
	{
		$items = MenuItem::find()->where(['status' => MenuItem::STATUS_ACTIVE])->andWhere(['IS NOT', 'route', NULL])->all();
		$rules = [];

		foreach($items as $item){

			/*if(!empty($item->params)){
				parse_str( $item->params, $params);
				$route = array_merge([$item->route], $params);
				o($route);
			}*/

			$params = [];
			if(!empty($item->params)){
				parse_str( $item->params, $params);
			}

		    $rules[] = [
		        'pattern' => $item->link,
		        'route' => $item->route,
                'defaults' => $params
            ];
        }

		/*foreach($items as $item){
			if($item->route != null){
                $lang = substr($item->language,  0, strpos($item->language, '-'));
				$rules[] = [
					'pattern' => '<_lang>/'.$item->link,
					'route' => $item->route,
					'defaults' => ['id' => $item->ref_id],
				];
			}
		}*/
		//v($rules);
		\Yii::$app->urlManager->addRules($rules);
	}
	
	
}