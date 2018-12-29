<?php

use yii\helpers\Html;
use backend\components\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\main\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <ul id="navigation" class="nav nav-tabs" role="tablist">
        <li class="active"><a data-toggle="tab" href="#main-form" aria-expanded="true">Main</a></li>
        <li class=""><a data-toggle="tab" href="#settings-form" aria-expanded="false">Settings</a></li>
    </ul>
    <div class="tab-content" style="margin-top:15px;">
        <div id="main-form" class="tab-pane active">
            <?php echo $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'status')->dropDownList(\backend\models\main\Menu::statusLabels()) ?>
            <?php echo $form->field($model, 'show_selected_items', [
                'options' => [
                    'class' => ['col-md-9 col-md-offset-3']
                ]
            ])->checkbox()->label('Show Active Items?')->hint('Highlight selected items?'); ?>
            <?php echo $form->field($model, 'show_selected_parents', [
                'options' => [
                    'class' => ['col-md-9 col-md-offset-3']
                ]
            ])->checkbox()->label('Show Active Parents?')->hint('Whether to highlight parent menu items when one of the corresponding child menu items is selected.'); ?>
        </div>
        <div id="settings-form" class="tab-pane">
            <div class="panel panel-default">
                <div class="panel-heading strong"><i class="fa fa-paint-brush"></i> Appearance</div>
                <div class="panel-body">
                    <?php echo $form->field($model, 'htmlClass')->textInput()->label('Class'); ?>
                    <?php echo $form->field($model, 'htmlStyle')->textInput()->label('CSS'); ?>
                </div>
            </div>
        </div>
    </div>



    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <?php echo \backend\components\helpers\AdminHelper::submitButton(); ?>
            <?php if($model->isNewRecord): ?>
                <?php echo \backend\components\helpers\AdminHelper::cancelButton(['index']); ?>
            <?php else: ?>
                <?php echo \backend\components\helpers\AdminHelper::cancelButton(['view', 'id' => $model->id]); ?>
            <?php endif; ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
