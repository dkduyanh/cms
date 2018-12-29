<?php

use yii\helpers\Html;
use backend\components\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\cms\Comment */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms/comment', 'Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="comment-view" class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo Html::encode($this->title) ?></h3>
            </div>
            <div class="box-body">
                <p>
                    <?php echo \backend\components\helpers\AdminHelper::backButton(['index']); ?>
                    <?php echo \backend\components\helpers\AdminHelper::editButton(['update', 'id' => $model->id]); ?>
                    <?php echo \backend\components\helpers\AdminHelper::deleteButton(['delete', 'id' => $model->id]); ?>
                </p>

                <?php echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'post_id',
                        'title',
                        'body:ntext',
                        'created_date',
                        'creator_id',
                        'creator_name',
                        'creator_email:email',
                        'creator_ip',
                        'last_modified_date',
                        'last_modifier_id',
                        'like_count',
                        'dislike_count',
                        'parent_id',
                        'status',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
