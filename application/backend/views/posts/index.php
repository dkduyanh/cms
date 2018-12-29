<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\components\widgets\GridView;
use yii\widgets\Pjax;
use backend\models\cms\Post;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PostList */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('cms/post', $searchModel->type->name);
$this->params['breadcrumbs'][] = 'Contents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="post-index" class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header"><h3 class="box-title"><small>Contents &raquo; </small><?php echo Html::encode($this->title) ?></h3></div>
            <div class="box-body">
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                <p>
                    <?php echo \backend\components\helpers\AdminHelper::createButton(['create', 'type' => $searchModel->type_id]); ?>
                </p>
                <?php Pjax::begin(); ?>
                <?php echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        /*[
                            'attribute' => 'id',
                            'headerOptions' => ['width' => '75px'],
                        ],*/
                        [
                            'attribute' => 'image',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) {
                                $imageUrl = \yii\helpers\Url::to('@web/img/default-image-150x150.png');
                                if($model->image){
                                    $imageUrl = $model->getImageUrl();
                                }
                                return Html::a(Html::img($imageUrl, ['width'=>'64px', 'height' => '64px']), ['view', 'id' => $model->id], ['data-pjax' => "0"]);
                            },
                            'headerOptions' => ['width' => '75px'],
                        ],
                        [
                            'attribute' => 'title',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) {
                                return Html::a($model->title, ['view', 'id' => $model->id], ['data-pjax' => "0"])."<br>".$model->code;
                            },
                        ],
                        //'code',
                        [
                            'attribute' => 'categories',
                            'format' => 'html',
                            'value' => function ($model, $key, $index, $column) {
                                $html = [];
                                foreach($model->categories as $cat){
                                    $html[] = Html::tag('span', $cat->name);
                                }
                                return $html ? implode(',', $html) : null;
                            },
                            'filter' => ArrayHelper::map(\backend\models\cms\Category::listAllInTree(), 'id', 'name')
                        ],
                        'created_date',
                        [
                            'attribute' => 'language',
                            'format' => 'text',
                            'filter' => ArrayHelper::map(\backend\models\main\Language::listAll(), 'code', 'name')
                        ],
                        [
                            'attribute' => 'is_sticky',
                            'format' => 'html',
                            'value' => function ($model, $key, $index, $column) {
                                return Html::tag('span', $model->stickyLabel, ['class' => $model->stickyClass]);
                            },
                            'filter' => Post::stickyLabels()
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'html',
                            'value' => function ($model, $key, $index, $column) {
                                return Html::tag('span', $model->statusLabel, ['class' => $model->statusClass]);
                            },
                            'filter' => Post::statusLabels()
                        ],
                        // 'body:ntext',
                        // 'filtered_body:ntext',
                        // 'image',
                        // 'image_alt',
                        // 'created_date',
                        // 'creator_id',
                        // 'last_modified_date',
                        // 'last_modifier_id',
                        // 'published_date',
                        // 'expiry_date',
                        // 'average_rating',
                        // 'view_count',
                        // 'like_count',
                        // 'dislike_count',
                        // 'comment_count',
                        // 'allow_comment',
                        // 'allow_search',
                        // 'privacy',
                        // 'is_sticky',
                        // 'parent_id',
                        // 'position',
                        // 'status',

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
