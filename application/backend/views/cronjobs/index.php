<?php

use yii\helpers\Html;
use backend\components\widgets\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CronjobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('acl', 'Cronjobs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="cronjob-index" class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header"><h3 class="box-title"><?php echo Html::encode($this->title) ?></h3></div>
            <div class="box-body">
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                <p>
                    <?php echo \backend\components\helpers\AdminHelper::createButton(['create']); ?>
                </p>
                <?php Pjax::begin(); ?>

                <?php echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        //'id',
                        [
                            'attribute' => 'name',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) {
                                return Html::a($model->name, ['view', 'id' => $model->id], ['data-pjax' => "0"]);
                            },
                            'filter' => \backend\models\main\CronJob::statusLabels()
                        ],
                        //'command',
                        //'created_date',
                        //'last_modified_date',
                        //'start_date',
                        //'end_date',
                        //'interval',
                        'next_run_date',
                        'last_run_date',
                        'last_run_result',
                        //'status',
                        [
                            'attribute' => 'status',
                            'format' => 'html',
                            'value' => function ($model, $key, $index, $column) {
                                $htmlClass = 'label label-';
                                switch($model->status){
                                    case \backend\models\main\CronJob::STATUS_ACTIVE:
                                        $htmlClass .= 'success';
                                        break;
                                    case \backend\models\main\CronJob::STATUS_RUNNING:
                                        $htmlClass .= 'danger';
                                        break;
                                    case \backend\models\main\CronJob::STATUS_QUEUED:
                                        $htmlClass .= 'warning';
                                        break;
                                    default: $htmlClass .= 'default';
                                }
                                return Html::tag('span', $model->statusLabel, ['class' => $htmlClass]);
                            },
                            'filter' => \backend\models\main\CronJob::statusLabels()
                        ],
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
