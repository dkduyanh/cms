<?php

use yii\helpers\Html;
use backend\components\widgets\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\EmailTemplateList */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('email_template', 'Email Templates');
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="email-template-index" class="row">
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

                        'id',
                        'code',
                        'name',
                        'description',
                        'subject',
                        // 'body:ntext',
                        // 'sender_email:email',
                        // 'sender_name',
                        // 'created_date',
                        // 'creator_id',
                        // 'last_modified_date',
                        // 'last_modifier_id',
                        // 'allow_delete',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
