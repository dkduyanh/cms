<?php

use yii\helpers\Html;
use backend\components\widgets\ActiveForm;
use backend\components\helpers\AdminHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\main\TextSource */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="text-source-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if($model->isNewRecord): ?>
        <?php echo $form->field($model, 'category')->textInput(['maxlength' => true]) ?>
    <?php endif; ?>

    <?php echo $form->field($model, 'message')->textInput() ?>

    <hr>

    <?php foreach(\backend\models\main\Language::listAll() as $lang): ?>
    <?php //echo $form->field($model, 'translations['.$lang->code.']')->textInput()->label($lang->code); ?>
        <?php echo $form->field($model, 'textTranslations['.$lang->code.']')->textInput()->label($lang->code); ?>
    <?php endforeach; ?>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <?php echo AdminHelper::submitButton(); ?>
            <?php echo Html::submitButton('<i class="fa fa-plus"></i> '.Yii::t('translation', 'Save & New'), ['class' => 'btn btn-success', 'name' => 'saveAndNew', 'value' => '1']); ?>
            <?php if($model->isNewRecord): ?>
                <?php echo AdminHelper::cancelButton(['index']); ?>
            <?php else: ?>
                <?php echo AdminHelper::cancelButton(['view', 'id' => $model->id]); ?>
            <?php endif; ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
