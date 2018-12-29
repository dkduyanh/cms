<?php

use yii\helpers\Html;
use backend\components\widgets\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\MediaList */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('cms/media', 'Media');
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="media-index" class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header"><h3 class="box-title"><?php echo Html::encode($this->title) ?></h3></div>
            <div class="box-body">
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                <p>
                    <?php echo Html::a(Yii::t('cms/media', 'Create Media'), ['create'], ['class' => 'btn btn-success']) ?>
                </p>
                <?php Pjax::begin(); ?>    
                <?php echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'id',
                        'parent_id',
                        'name',
                        'content_path',
                        'content',
                        // 'size',
                        // 'extension',
                        // 'mime',
                        // 'hash',
                        // 'metadata:ntext',
                        // 'creator_id',
                        // 'created_date',
                        // 'last_modifier_id',
                        // 'last_modified_date',
                        // 'is_visible',
                        // 'is_locked',
                        // 'position',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
