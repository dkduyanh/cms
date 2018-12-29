<?php

use yii\helpers\Html;
use backend\components\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\main\SystemLog */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('SystemLog', 'System Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="system-log-view" class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">LOG ID: <?php echo Html::encode($this->title) ?></h3>
            </div>
            <div class="box-body">
                <p>
                    <?php echo \backend\components\helpers\AdminHelper::backButton(['index']); ?>
                </p>

                <?php echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'level',
                        'env',
                        'category',
                        'created',
                        'message:ntext',
                        'extras:ntext',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
