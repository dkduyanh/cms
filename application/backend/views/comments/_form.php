<?php

use yii\helpers\Html;
use backend\components\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\cms\Comment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'post_id')->textInput() ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <?php echo $form->field($model, 'created_date')->textInput() ?>

    <?php echo $form->field($model, 'creator_id')->textInput() ?>

    <?php echo $form->field($model, 'creator_name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'creator_email')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'creator_ip')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'last_modified_date')->textInput() ?>

    <?php echo $form->field($model, 'last_modifier_id')->textInput() ?>

    <?php echo $form->field($model, 'like_count')->textInput() ?>

    <?php echo $form->field($model, 'dislike_count')->textInput() ?>

    <?php echo $form->field($model, 'parent_id')->textInput() ?>

    <?php echo $form->field($model, 'status')->textInput() ?>

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
