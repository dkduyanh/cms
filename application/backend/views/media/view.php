<?php

use yii\helpers\Html;
use backend\components\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\cms\Media */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms/media', 'Media'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="media-view" class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo Html::encode($this->title) ?></h3>
            </div>
            <div class="box-body">
                <p>
                    <?php echo \backend\components\helpers\AdminHelper::backButton(['index']); ?>
                    <?php echo Html::a(Yii::t('cms/media', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?php echo Html::a(Yii::t('cms/media', 'Delete'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('cms/media', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>
                <?php echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'parent_id',
                        'name',
                        'content_path',
                        'content',
                        'size',
                        'extension',
                        'mime',
                        'hash',
                        'metadata:ntext',
                        'creator_id',
                        'created_date',
                        'last_modifier_id',
                        'last_modified_date',
                        'is_visible',
                        'is_locked',
                        'position',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
