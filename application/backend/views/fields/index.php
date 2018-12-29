<?php

use yii\helpers\Html;
use backend\components\widgets\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\FieldList */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('cms/fields', 'Fields');
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="field-index" class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header"><h3 class="box-title"><?php echo Html::encode($this->title) ?></h3></div>
            <div class="box-body">
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                <p>
                    <?php echo \backend\components\helpers\AdminHelper::createButton(['create']); ?>
                </p>
                <?php Pjax::begin(); ?>    <?php echo GridView::widget([
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
                        ],
                        'code',
                        'description',
                        // 'group',
                        // 'position',
                        // 'settings:ntext',

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
