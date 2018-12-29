<?php

use yii\helpers\Html;
use backend\components\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\main\Language */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('languages', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="language-view" class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo Html::encode($this->title) ?></h3>
            </div>
            <div class="box-body">
                <p>
                    <?php echo \backend\components\helpers\AdminHelper::backButton(['index']); ?>
                    <?php echo \backend\components\helpers\AdminHelper::editButton(['update', 'id' => $model->code]); ?>
                    <?php echo \backend\components\helpers\AdminHelper::deleteButton(['delete', 'id' => $model->code]); ?>
                </p>
                <?php echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'code',
                        'name',
                        'nativename',
                        'direction',
                        'image',
                        [
                            'attribute' => 'is_default',
                            'format' => 'html',
                            'value' => $model->isDefault()?
                                            Html::tag('span', Yii::t('common', 'YES'), ['class' => 'label label-success'])
                                            :
                                            Html::tag('span', Yii::t('common', 'NO'), ['class' => 'label label-danger'])
                        ],
                        'position',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
