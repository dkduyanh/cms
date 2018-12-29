<?php

use yii\helpers\Html;
use backend\components\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\cms\Media */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="media-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'parent_id')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'content_path')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'content')->textInput() ?>

    <?php echo $form->field($model, 'size')->textInput() ?>

    <?php echo $form->field($model, 'extension')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'mime')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'hash')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'metadata')->textarea(['rows' => 6]) ?>

    <?php echo $form->field($model, 'creator_id')->textInput() ?>

    <?php echo $form->field($model, 'created_date')->textInput() ?>

    <?php echo $form->field($model, 'last_modifier_id')->textInput() ?>

    <?php echo $form->field($model, 'last_modified_date')->textInput() ?>

    <?php echo $form->field($model, 'is_visible')->textInput() ?>

    <?php echo $form->field($model, 'is_locked')->textInput() ?>

    <?php echo $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <?php echo Html::submitButton($model->isNewRecord ? Yii::t('cms/media', 'Create') : Yii::t('cms/media', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
