<?php

use yii\helpers\Html;
use backend\components\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\main\Cronjob */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('acl', 'Cronjobs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="cronjob-view" class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo Html::encode($this->title) ?></h3>
            </div>
            <div class="box-body">
                <p>
                    <?php echo \backend\components\helpers\AdminHelper::backButton(['index']); ?>
                    <?php echo Html::a(Yii::t('acl', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?php echo Html::a(Yii::t('acl', 'Delete'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('acl', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>

                <?php echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        //'id',
                        'name',
                        'command',
                        'created_date',
                        'creator_id',
                        'last_modified_date',
                        'last_modifier_id',
                        'start_date',
                        'end_date',
                        'interval',
                        'next_run_date',
                        'last_run_date',
                        'last_run_result',
                        'position',
                        [
                            'attribute' => 'status',
                            'format' => 'html',
                            'value' => function($model){
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
                            }
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
