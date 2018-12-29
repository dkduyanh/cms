<?php

use yii\helpers\Html;
use \backend\components\widgets\GridView;
use yii\widgets\Pjax;
use backend\models\main\Menu;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('menu', 'Menus');
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="menu-index" class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header"><h3 class="box-title"><?php echo Html::encode($this->title) ?></h3></div>
            <div class="box-body">
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                <p>
                    <?php echo \backend\components\helpers\AdminHelper::createButton(['create']); ?>
                </p>
                <?php Pjax::begin(); ?>
                <?php echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        //'id',
                        [
                            'attribute' => 'name',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) {
                                return Html::a($model->name, ['items', 'id' => $model->id], ['data-pjax' => "0"]);
                            },
                        ],
                        'code',
                        'description',
                        [
	                        'attribute' => 'status',
	                        'format' => 'html',
	                        'value' => function ($model, $key, $index, $column) {
	                        $htmlClass = [
	                        		Menu::STATUS_ACTIVE => 'label label-success',
	                        		Menu::STATUS_INACTIVE => 'label label-danger',
	                        ];
	                        return Html::tag('span', $model->statusLabel, ['class' => $htmlClass[$model->status]]);
	                        },
	                        'filter' => Menu::statusLabels()
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['width' => '75px'],
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
