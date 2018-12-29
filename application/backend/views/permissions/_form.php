<?php

use yii\helpers\Html;
use backend\components\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\main\AclAction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="acl-action-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'category')->textInput(['maxlength' => true]) ?>

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
