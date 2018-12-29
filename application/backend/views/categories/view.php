<?php

use yii\helpers\Html;
use backend\components\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\cms\Category */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms/category', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="category-view" class="row">
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
                        'code',
                        'name',
                        'description',
                        'created_date',
                        [
                            'attribute' => 'creator_id',
                            'value' => isset($model->creator)?$model->creator->displayname:null,
                        ],
                        'last_modified_date',
                        [
                            'attribute' => 'last_modifier_id',
                            'value' => isset($model->lastModifier)?$model->lastModifier->displayname:null,
                        ],
                        'image',
                        'image_alt',
                        'position',
                        'is_sticky',
                        'parent_id',
                        [
                            'attribute' => 'status',
                            'format' => 'html',
                            'value' => Html::tag('span', $model->getStatusLabel(), ['class' => 'label '.($model->status == \backend\models\cms\Category::STATUS_ACTIVE ? 'label-success':'label-danger')])
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
