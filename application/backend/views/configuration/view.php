<?php

use yii\helpers\Html;
use backend\components\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\main\Configuration */

$this->title = $model->code;
$this->params['breadcrumbs'][] = ['label' => Yii::t('configuration', 'Configurations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="configuration-view" class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo Html::encode($this->title) ?></h3>
            </div>
            <div class="box-body">
                <p>
                    <?php echo \backend\components\helpers\AdminHelper::backButton(['index']); ?>
                    <?php echo Html::a(Yii::t('configuration', 'Update'), ['update', 'id' => $model->code], ['class' => 'btn btn-primary']) ?>
                    <?php echo Html::a(Yii::t('configuration', 'Delete'), ['delete', 'id' => $model->code], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('configuration', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>

                <?php echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'code',
                        'value:ntext',
                        'autoload',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
