<?php

use yii\helpers\Html;
use backend\components\widgets\GridView;
use yii\widgets\Pjax;
use backend\models\cms\Category;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategoryList */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('cms/category', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\JqueryTreeGridAsset::register($this);
?>
<div id="category-index" class="row">
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
                    'filterModel' => false, //$searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        //'id',
                        [
                            'attribute' => 'name',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) {
                                $stroke = '';
                                if(isset($model['level']) && $model['level'] > 0){
                                    $stroke = '|-- ';
                                    for($i = 0; $i<$model['level']; $i++)
                                        $stroke = "&nbsp;&nbsp;&nbsp;&nbsp;".$stroke;
                                }
                                return $stroke.Html::a($model['name'], \yii\helpers\Url::to(['view', 'id' => $model['id']]), ['data-pjax'=>"0"]);
                            },
                            'headerOptions' => ['width' => '40%'],
                        ],
                        [
                        	'attribute' => 'code',
                        	'headerOptions' => ['width' => '200px'],
						],
                        'description',
                        'created_date',
                        // 'creator_id',
                        // 'last_modified_date',
                        // 'last_modifier_id',
                        // 'image',
                        // 'image_alt',
                        // 'position',
                        // 'is_sticky',
                        // 'parent_id',
                        // 'status',
                        // 'settings:ntext',

                        [
                            'attribute' => 'status',
                            'format' => 'html',
                            'value' => function ($model, $key, $index, $column) {
                                return Html::tag('span', @Category::statusLabels()[$model['status']], ['class' => @Category::statusLabelClasses()[$model['status']]]);
                            },
                            'filter' => Category::statusLabels()
                        ],

                        [
                        	'class' => 'yii\grid\ActionColumn',
                        	'headerOptions' => ['width' => '75px'],		
                        ],
                    ],
                    'rowOptions' => function ($model, $key, $index, $grid) {
                        $class = 'treegrid-'.$model['id'];
                        if($model['parent_id']){
                            $class .= ' treegrid-parent-'.$model['parent_id'];
                        }
                        return [

                            'class' => $class
                        ];
                    },
                    'tableOptions' => [
                        'class' => 'table table-bordered table-hover treegrid'
                    ]
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJs("
$(document).ready(function() {
    $('.treegrid').treegrid({
        treeColumn: 1
    });
});
");
?>