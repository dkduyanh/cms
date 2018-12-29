<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\cms\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms/post', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="post-view" class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo Html::encode($this->title) ?></h3>
            </div>
            <div class="box-body">
                <p>
                    <?php echo \backend\components\helpers\AdminHelper::backButton(['index', 'type' => $model->type_id]); ?>
                    <?php echo \backend\components\helpers\AdminHelper::editButton(['update', 'id' => $model->id]); ?>
                    <?php echo \backend\components\helpers\AdminHelper::deleteButton(['delete', 'id' => $model->id]); ?>
                </p>

                <?php echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'type.name',
                        'code',
                        'title',
                        'intro:ntext',
                        'body:html',
                        'filtered_body:ntext',
                        [
                            'attribute' => 'image',
                            'format' => 'raw',
                            'value' => Html::img($model->getImageUrl(), ['style' => 'max-height:120px; max-height:120px'])
                        ],
                        'image_alt',
                        'created_date',
                        'creator.displayname',
                        'last_modified_date',
                        'lastModifier.displayname',
                        'published_date',
                        'expiry_date',
                        'average_rating',
                        'view_count',
                        'like_count',
                        'dislike_count',
                        'comment_count',
                        [
                            'attribute' => 'allow_comment',
                            'value' => $model->getAllowCommentLabel(),
                        ],
                        [
                            'attribute' => 'allow_search',
                            'value' => $model->getAllowSearchLabel(),
                        ],
                        'privacy',
                        [
                            'attribute' => 'is_sticky',
                            'value' => $model->getStickyLabel(),
                        ],
                        'language',
                        [
                            'attribute' => 'parent_id',
                            'format' => 'html',
                            'value' => $model->parent_id ? Html::a($model->parent->title, ['view', 'id' => $model->parent_id], ['target' => '_blank']) : null
                        ],
                        'position',
                        [
                            'attribute' => 'status',
                            'format' => 'html',
                            'value' => Html::tag('span', $model->statusLabel, ['class' => $model->statusClass]),
                        ]
                    ],
                ]) ?>

                <h3>Custom Fields</h3>
	            <?php echo DetailView::widget([
		            'model' => $model->getFieldValues(),
		            'attributes' => [

		            ],
	            ]) ?>
            </div>
        </div>
    </div>
</div>
