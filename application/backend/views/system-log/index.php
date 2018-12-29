<?php

use yii\helpers\Html;
use backend\components\widgets\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SystemLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('SystemLog', 'System Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="system-log-index" class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header"><h3 class="box-title"><?php echo Html::encode($this->title) ?></h3></div>
            <div class="box-body">
                <?php Pjax::begin(); ?>
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                <hr>
                <p>
                    <?php echo Html::a(Yii::t('SystemLog', '<i class="fa fa-trash"></i> '.'Truncate'), ['truncate'], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'url' => ['truncate'],
                            'confirm' => Yii::t('common', 'Are you sure you want to truncate all data?'),
                            'method' => 'post',
                        ]
                    ]) ?>
                </p>

                <?php echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        //'id',
                        [
                            'attribute' => 'env',
                            'headerOptions' => ['width' => '100px'],
                        ],
                        [
                            'attribute' => 'level',
                            'format' => 'html',
                            'value' => function ($model, $key, $index, $column) {
                                return $model->levelLabel;
                            },
                            'headerOptions' => ['width' => '100px'],
                            'filter' => \backend\models\main\SystemLog::levelLabels()
                        ],
                        'category',
                        [
                            'attribute' => 'created',
                            'value' => function ($model, $key, $index, $column) {
                                return date('Y-m-d H:i:s', $model->created);
                            },
                            'headerOptions' => ['width' => '100px'],
                        ],
                        [
                            'attribute' => 'message',
                            'format' => 'ntext',
                            'headerOptions' => ['width' => '200px'],
                        ],
                        //'extras:ntext',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view} {delete}',
                            'headerOptions' => ['width' => '50px'],
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
