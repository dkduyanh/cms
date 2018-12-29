<?php

use yii\helpers\Html;
use backend\components\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SystemLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div id="system-log-search" class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options' => [
                'class' => 'form-horizontal',
                'data-pjax' => 1
            ],
        ]); ?>

        <?php echo $form->field($model, 'level')->dropDownList(\backend\models\main\SystemLog::levelLabels(), [
                'prompt' => 'All',
        ]) ?>

        <?php //echo $form->field($model, 'env') ?>

        <?php //echo $form->field($model, 'category') ?>

        <?php echo $form->field($model, 'created') ?>

        <?php echo $form->field($model, 'message') ?>

        <?php // echo $form->field($model, 'extras') ?>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
                <?php echo Html::submitButton(Yii::t('SystemLog', 'Search'), ['class' => 'btn btn-primary']) ?>
                <?php echo Html::resetButton(Yii::t('SystemLog', 'Reset'), ['class' => 'btn btn-default']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php $this->registerJs("
    $('#".Html::getInputId($model, 'created')."').datepicker({
        'dateFormat': 'dd/mm/yy'
    });
"); ?>
