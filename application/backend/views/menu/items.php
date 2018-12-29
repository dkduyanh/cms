<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use \backend\components\widgets\GridView;
use yii\widgets\Pjax;
use backend\models\main\MenuItem;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('menu', 'Menu Items');
$this->params['breadcrumbs'][] = ['label' => Yii::t('menu', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $menuModel->name, 'url' => ['view', 'id' => $menuModel->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="menu-index" class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header"><h3 class="box-title"><?php echo Html::encode($this->title) ?></h3></div>
            <div class="box-body">
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                <p>
	                <?php echo \backend\components\helpers\AdminHelper::backButton(['menu/index']); ?>
                    <?php echo \backend\components\helpers\AdminHelper::createButton(['update-item', 'menu' => $menuModel->id], 'Create New Item'); ?>
                </p>
                <?php Pjax::begin(); ?>
                <?php echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'name',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) {
	                            $stroke = '';
	                            if(isset($model->level) && $model->level > 0){
		                            $stroke = '|-- ';
		                            for($i = 0; $i<$model->level; $i++)
			                            $stroke = "&nbsp;&nbsp;&nbsp;&nbsp;".$stroke;
	                            }
	                            return $stroke.Html::a($model->name, ['update-item', 'menu' => $model->menu->id, 'id' => $model->id], ['data-pjax'=>"0"]);
                            },
                        ],
                        'link',
                        'position',
                        [
                        	'attribute' => 'status',
                       		'format' => 'html',
                            'value' => function ($model, $key, $index, $column) {
                            	$htmlClass = [
                            		MenuItem::STATUS_ACTIVE => 'label label-success',
                            		MenuItem::STATUS_INACTIVE => 'label label-danger',
                            	];                            
                                return Html::tag('span', $model->statusLabel, ['class' => $htmlClass[$model->status]]);
                            },
                            'filter' => MenuItem::statusLabels()
                        ],
                        [
                            'attribute' => 'language',
                            'format' => 'text',
                            'filter' => ArrayHelper::map(\backend\models\main\Language::listAll(), 'code', 'name')
                        ],
                        // 'settings:ntext',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update} {delete}',
                            'urlCreator' => function ($action, $model, $key, $index) {
                                if ($action === 'view') {
                                    return ['view-item', 'menu' => $model->menu->id, 'id' => $model->id];
                                }
                                else if ($action === 'update') {
                                    return ['update-item', 'menu' => $model->menu->id, 'id' => $model->id];
                                }
                                else if ($action === 'delete') {
                                    return ['delete-item', 'menu' => $model->menu->id, 'id' => $model->id];
                                }
                            }
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>