<?php

use yii\helpers\Html;
use backend\components\widgets\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AclActionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('acl', 'Acl Actions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="acl-action-index" class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header"><h3 class="box-title"><?php echo Html::encode($this->title) ?></h3></div>
            <div class="box-body">
                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <p>
                    <?php echo Html::a(Yii::t('acl', 'Create Acl Action'), ['create'], ['class' => 'btn btn-success']) ?>
                </p>

                <?php echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'id',
                        'code',
                        'name',
                        'description',
                        'category',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
