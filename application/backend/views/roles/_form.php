<?php

use yii\helpers\Html;
use backend\components\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\main\Role */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="role-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'description')->textarea(['maxlength' => true, 'rows' => 5]) ?>

    <?php echo $form->field($model, 'is_admin')->checkbox(['class' => 'js-switch'], false) ?>

    <?php echo $form->field($model, 'is_default')->checkbox(['class' => 'js-switch'], false) ?>

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
