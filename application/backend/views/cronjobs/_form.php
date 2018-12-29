<?php

use yii\helpers\Html;
use backend\components\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\main\Cronjob */
/* @var $form yii\widgets\ActiveForm */

\backend\assets\DateTimePickerAsset::register($this);
?>

<div class="cronjob-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'type')->dropDownList(\backend\models\main\CronJob::typeLabels()) ?>

    <?php echo $form->field($model, 'command')->textarea(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'interval')->dropDownList(\backend\models\main\CronJob::predefinedIntervalLabels()) ?>

    <?php echo $form->field($model, 'start_date')->textInput()->hint('YYYY-MM-DD hh:mm:ss') ?>

    <?php echo $form->field($model, 'end_date')->textInput()->hint('YYYY-MM-DD hh:mm:ss') ?>

    <?php echo $form->field($model, 'position')->textInput(['type' => 'number']) ?>

    <?php echo $form->field($model, 'status')->dropDownList(\backend\models\main\CronJob::statusLabels()) ?>

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

<?php $this->registerJs("
    $(function () {
        $('#".Html::getInputId($model, 'start_date')."').datetimepicker({
            inline: true,
            sideBySide: true,
            format: 'YYYY-MM-DD hh:mm:ss'
        });
        $('#".Html::getInputId($model, 'end_date')."').datetimepicker({
            inline: true,
            sideBySide: true,
            format: 'YYYY-MM-DD hh:mm:ss'
        });
    });
"); ?>
