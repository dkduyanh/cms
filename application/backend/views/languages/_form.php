<?php

use yii\helpers\Html;
use backend\components\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\main\Language */
/* @var $form yii\widgets\ActiveForm */
?>

<div id="language-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'code')->dropDownList(\common\library\Utils::getLocalesWithDisplayName()) ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'nativename')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'image')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'direction')->dropDownList(\backend\models\main\Language::directionLabels()) ?>

    <?php echo $form->field($model, 'is_default')->checkbox(['class' => 'js-switch'], false)  ?>

    <?php echo $form->field($model, 'position')->textInput(['type' => 'number']); ?>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <?php echo Html::submitButton(Yii::t('languages', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs("
$(document).ready(function() {
    $('#".Html::getInputId($model, 'code')."').select2();   
});		
");
?>

