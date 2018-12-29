<?php

use yii\helpers\Html;
use backend\components\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\main\Menu */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('menu', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="menu-view" class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo Html::encode($this->title) ?></h3>
            </div>
            <div class="box-body">
                <p>
                    <?php echo \backend\components\helpers\AdminHelper::backButton(['index']); ?>
                    <?php echo Html::a('<i class="fa fa-sitemap"></i> '.Yii::t('menu', 'Menu Items'), ['items', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
                    <?php echo \backend\components\helpers\AdminHelper::editButton(['update', 'id' => $model->id]); ?>
                    <?php echo \backend\components\helpers\AdminHelper::deleteButton(['delete', 'id' => $model->id]); ?>
                </p>
                <?php echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'code',
                        'name',
                        'description',
                        [
                            'attribute' => 'status',
                            'value' => $model->statusLabel
                        ],
                        [
                            'attribute' => 'show_selected_items',
                            'value' => $model->show_selected_items ? 'YES' : 'NO'
                        ],
                        [
                            'attribute' => 'show_selected_parents',
                            'value' => $model->show_selected_parents ? 'YES' : 'NO'
                        ],
                        //'settings:ntext',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
