<?php

use yii\helpers\Html;
use backend\components\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\main\TextSource */

$this->title = \yii\helpers\StringHelper::truncate($model->message, '75');
$this->params['breadcrumbs'][] = ['label' => Yii::t('translation', 'Text Sources'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="text-source-view" class="row">
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

                <?php
                $cols = [];
                $trans = \yii\helpers\ArrayHelper::index($model->translations, 'language');
                foreach(\backend\models\main\Language::listAll() as $lang){
                    $cols[] = [
                        'label' => $lang->code,
                        'value' => @$trans[$lang->code]->translation
                    ];
                }
                echo DetailView::widget([
                    'model' => $model,
                    'attributes' => \yii\helpers\ArrayHelper::merge([
                        'id',
                        'category',
                        'message:ntext',
                    ], $cols),
                ]) ?>
            </div>
        </div>
    </div>
</div>
