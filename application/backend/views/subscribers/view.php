<?php

use yii\helpers\Html;
use backend\components\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\subscription\Subscriber */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('subscription/subscriber', 'Subscribers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="subscriber-view" class="row">
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
                <?php echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'code',
                        'fullname',
                        'email:email',
                        'created_date',
                        'ip_address',
                        'confirmed',
                        'status',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
