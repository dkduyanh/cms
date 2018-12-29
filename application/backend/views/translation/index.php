<?php

use yii\helpers\Html;
use backend\components\widgets\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\main\TextSourceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('translation', 'Text Sources');
$this->params['breadcrumbs'][] = $this->title;
?>


<div id="text-source-index" class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header"><h3 class="box-title"><?php echo Html::encode($this->title) ?></h3></div>
            <div class="box-body">
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <p>
                    <?php echo \backend\components\helpers\AdminHelper::backButton(['languages/index']); ?>
                    <?php echo Html::a(Yii::t('translation', 'Add Text Source'), ['create'], ['class' => 'btn btn-success']) ?>
                    <?php echo Html::a(Yii::t('translation', 'Import'), /*['import']*/ 'javascript:void(0);', ['class' => 'btn btn-success']) ?>
                    <?php echo Html::a(Yii::t('translation', 'Export'), /*['export']*/ 'javascript:void(0);', ['class' => 'btn btn-success']) ?>
                </p>

                <?php Pjax::begin(); ?>

                <?php $gridCols = [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'headerOptions' => ['width' => '75px']
                    ],
                    //'id',
                    //'category',
                    [
                        'attribute' => 'message',
                        'format' => 'raw',
                        'value' => function ($model, $key, $index, $column) {
                            return Html::a($model->message, ['update', 'id' => $model->id], ['data-pjax' => "0"]);
                        },
                        'headerOptions' => ['width' => '25%'],
                    ],
                ]; ?>
                <?php foreach($searchModel->installedLanguages as $lang): ?>
                    <?php
                    $gridCols[] = [
                        'attribute' => '_translations['.$lang->code.']',
                        'label' => $lang->name,
                        'value' => function ($model, $key, $index, $column) use ($lang) {
                            $trans = \yii\helpers\ArrayHelper::index($model->translations, 'language');
                            foreach($trans as $tran){
                                if($tran->language == $lang->code){
                                    return $tran->translation;
                                }
                            };
                            return null;
                        },
                        'filter' => true,
                    ];
                    ?>
                <?php endforeach; ?>
                <?php $gridCols[] = [
                    'class' => 'yii\grid\ActionColumn',
                    'headerOptions' => ['width' => '75px'],
                ] ; ?>

                <?php echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => $gridCols,
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
