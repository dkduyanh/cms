<?php

use yii\helpers\Html;
use backend\components\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\cms\Type */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<?php echo $form->field($model, 'plural_name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'description')->textarea(['maxlength' => true, 'rows' => 5]) ?>

	<?php echo $form->field($model, 'is_visible')->checkbox(['class' => 'js-switch'], false) ?>

    <hr>
    <h2>Built-in Columns</h2>

    <?php echo $form->field($model, 'show_title')->checkbox(['class' => 'js-switch'], false) ?>
    <?php echo $form->field($model, 'show_intro')->checkbox(['class' => 'js-switch'], false) ?>
    <?php echo $form->field($model, 'show_body')->checkbox(['class' => 'js-switch'], false) ?>
    <?php echo $form->field($model, 'show_image')->checkbox(['class' => 'js-switch'], false) ?>
    <?php echo $form->field($model, 'show_image_alt')->checkbox(['class' => 'js-switch'], false) ?>
    <?php echo $form->field($model, 'show_categories')->checkbox(['class' => 'js-switch'], false) ?>
    <?php echo $form->field($model, 'show_tags')->checkbox(['class' => 'js-switch'], false) ?>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <?php echo Html::submitButton($model->isNewRecord ? Yii::t('cms/types', 'Create') : Yii::t('cms/types', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?php if($model->isNewRecord): ?>
                <?php echo Html::a(Yii::t('common', 'Cancel'), ['index'], ['class' => 'btn btn-default']) ?>
            <?php else: ?>
                <?php echo Html::a(Yii::t('common', 'Cancel'), ['view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
            <?php endif; ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
