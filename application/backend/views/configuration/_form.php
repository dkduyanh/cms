<?php

use yii\helpers\Html;
use backend\components\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\main\Configuration */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="configuration-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'value')->textarea(['rows' => 6]) ?>

    <?php echo $form->field($model, 'autoload')->textInput() ?>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <?php echo Html::submitButton($model->isNewRecord ? Yii::t('configuration', 'Create') : Yii::t('configuration', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?php if($model->isNewRecord): ?>
                <?php echo Html::a(Yii::t('common', 'Cancel'), ['index'], ['class' => 'btn btn-default']) ?>
            <?php else: ?>
                <?php echo Html::a(Yii::t('common', 'Cancel'), ['view', 'id' => $model->code], ['class' => 'btn btn-default']) ?>
            <?php endif; ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
