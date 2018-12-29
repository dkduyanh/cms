<?php

use yii\helpers\Html;
use \backend\components\widgets\ActiveForm;

$this->title = Yii::t('cms/types', 'Update Fields');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms/types', 'Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms/types', $model->type->name), 'url' => ['view', 'id' => $model->type->id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div id="type-create" class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo Html::encode($this->title) ?></h3>
            </div>
            <div class="box-body">
                <?php $form = ActiveForm::begin(); ?>
                    <?php echo $form->field($model, '_fieldId')->dropDownList(\yii\helpers\ArrayHelper::map(\backend\models\cms\Field::listAll(), 'id', 'name')); ?>
                    <?php echo $form->field($model, '_defaultValue')->textInput(); ?>
                    <?php echo $form->field($model, '_position')->textInput(['type' => 'number']); ?>
	                <?php echo $form->field($model, '_multiple')->checkbox([], false); ?>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <?php echo Html::submitButton(Yii::t('cms/types', 'Update'), ['class' => 'btn btn-primary']) ?>
                            <?php echo Html::a(Yii::t('common', 'Cancel'), ['view', 'id' => $model->type->id], ['class' => 'btn btn-default']) ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php 
$this->registerJs("
$(document).ready(function() {
    $('#".Html::getInputId($model, '_fieldId')."').select2();   
});		
");
?>