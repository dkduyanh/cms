<?php

use yii\helpers\Html;
use backend\components\widgets\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CommentList */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('cms/comment', 'Comments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="comment-index" class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header"><h3 class="box-title"><?php echo Html::encode($this->title) ?></h3></div>
            <div class="box-body">
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                <p>
                    <?php //echo \backend\components\helpers\AdminHelper::createButton(['create']); ?>
                </p>
                <?php Pjax::begin(); ?>
                <?php echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        //'id',
                        'post_id',
                        'title',
                        'body:ntext',
                        'created_date',
                        // 'creator_id',
                        // 'creator_name',
                        // 'creator_email:email',
                        // 'creator_ip',
                        // 'last_modified_date',
                        // 'last_modifier_id',
                        // 'like_count',
                        // 'dislike_count',
                        // 'parent_id',
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
