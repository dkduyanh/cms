<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\main\Language;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\LanguageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('languages', 'Languages');
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="languages-index" class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header"><h3 class="box-title"><?php echo Html::encode($this->title) ?></h3></div>
                <div class="box-body">
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <p>
                        <?php echo \backend\components\helpers\AdminHelper::createButton(['create']); ?>
                        <?php echo Html::a(Yii::t('languages', 'Translations'), ['translation/index'], ['class' => 'btn btn-primary']) ?>
                    </p>

                    <?php Pjax::begin(); ?>
                    <?php echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            [
                                'attribute' => 'code',
                                'format' => 'raw',
                                'value' => function ($model, $key, $index, $column){
                                    return Html::a($model->code, ['view', 'id' => $model->code], ['data-pjax' => "0"]);
                                },
                                'headerOptions' => ['width' => '120px'],
                            ],
                            'name',
                            'nativename',
                            [
                                'attribute' => 'direction',
                                'filter' => Language::directionLabels()
                            ],
                            'image',
                            [
                                'attribute' => 'is_default',
                                'format' => 'raw',
                                'value' => function ($model, $key, $index, $column){
                                    return $model->isDefault()?
                                        Html::tag('span', Yii::t('common', 'YES'), ['class' => 'label label-success'])
                                        :
                                        Html::tag('span', Yii::t('common', 'NO'), ['class' => 'label label-danger']);
                                },
                                'headerOptions' => ['width' => '75px'],
                            ],
                            //'position',

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
