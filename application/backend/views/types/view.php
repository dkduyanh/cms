<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use backend\components\widgets\DetailView;
use \backend\components\widgets\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\cms\Type */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms/types', 'Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="type-view" class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><small><?php echo Yii::t('cms/types', 'Type'); ?> &raquo; </small><?php echo Html::encode($this->title) ?></h3>
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
                        'plural_name',
                        'description',
                        [
                            'attribute' => 'is_visible',
                            'format' => 'html',
                            'value' => Html::tag('span', $model->is_visible ? 'YES':'NO', ['class' => 'label label-'.($model->is_visible?'success':'danger')])
                        ]
                    ],
                ]) ?>

                <hr>
                <h4>Custom Fields</h4>
                <?php echo $this->render('_list_fields', [
                    'model' => $model,
                    'dataProvider' => $dataProvider,
                ]); ?>
            </div>
        </div>
    </div>
</div>
