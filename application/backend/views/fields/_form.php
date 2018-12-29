<?php

use yii\helpers\Html;
use backend\components\widgets\ActiveForm;
use backend\models\cms\Field;

/* @var $this yii\web\View */
/* @var $model common\models\cms\Field */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="field-form">
    <?php $form = ActiveForm::begin(); ?>
    <ul id="navigation" class="nav nav-tabs" role="tablist">
        <li class="active"><a data-toggle="tab" href="#main-form" aria-expanded="true">Main</a></li>
        <li class=""><a data-toggle="tab" href="#settings-form" aria-expanded="false">Settings</a></li>
    </ul>
    <div class="tab-content" style="margin-top:15px;">
        <div id="main-form" class="tab-pane active">
            <?php echo $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'description')->textarea(['maxlength' => true, 'rows' => 5]) ?>
            <?php echo $form->field($model, 'group')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'position')->textInput(['type' => 'number']) ?>
        </div>
        <div id="settings-form" class="tab-pane">
            <?php echo $form->field($model, 'input_type')->dropDownList(Field::getInputTypes()); ?>
            <?php echo $form->field($model, 'data_type')->dropDownList(Field::getDataTypes())->label('Data type'); ?>
            <div class="form-group hide" id="field_settings_list">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Data list <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php $count = $model->isNewRecord || empty($model->settings['list']) ? 3 : count($model->settings['list']); ?>
                    <?php for($i=0; $i<$count; $i++): ?>
                        <div class="form-group">
                            <?php echo $form->field($model, "settings[list][{$i}][value]", [
                                'options' => ['class' => 'col-xs-5'],
                                'template' => '{input}',
                                'inputOptions' => [
                                    'placeholder' => Yii::t('common', 'Value'),
                                ]
                            ])->textInput(); ?>
                            <?php echo $form->field($model, "settings[list][{$i}][name]", [
                                'options' => ['class' => 'col-xs-5'],
                                'template' => '{input}',
                                'inputOptions' => [
                                    'placeholder' => Yii::t('common', 'Label'),
                                ]
                            ])->textInput(); ?>

                            <div class="col-xs-1"><?php echo Html::tag('a', '<i class="fa fa-minus"></i>', ['class' => 'btn btn-default', 'onclick' => 'removeButton(this);'])?></div>
                        </div>
                    <?php endfor; ?>

                    <div class="form-group hide" id="list_item_sample">
                        <div class="col-xs-5"><input class="form-control" type="text" id="sample_input_value" placeholder="Value" value=""></div>
                        <div class="col-xs-5"><input class="form-control" type="text" id="sample_input_name" placeholder="Label" value=""> </div>
                        <div class="col-xs-1"><a class="btn btn-default" onClick="removeButton(this);"><i class="fa fa-minus"></i></a></div>
                    </div>
                    <div><?php echo Html::tag('a', '<i class="fa fa-plus"></i>', ['class' => 'btn btn-default', 'onclick' => 'addButton();'])?></div>
                </div>
            </div>
            <?php echo $form->field($model, 'is_required')->checkbox(['class' => 'js-switch'], false)->label('Required'); ?>
            <?php echo $form->field($model, 'default_value')->textInput(); ?>
	        <?php echo $form->field($model, 'hint')->textInput(); ?>
            <?php echo $form->field($model, 'settings[class]')->textInput()->label('Class'); ?>
            <?php echo $form->field($model, 'settings[style]')->textInput()->label('Style'); ?>
        </div>
    </div>
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

<script>
    function addButton(){
        var index = parseInt($('#field_settings_list > div > .form-group').length) - 1;
        var template = $('#list_item_sample');
        var inputValueName = '<?php echo Html::getInputName($model, 'settings[list][index][value]'); ?>'.replace('[index]', '['+index+']');
        var inputLabelName = '<?php echo Html::getInputName($model, 'settings[list][index][name]'); ?>'.replace('[index]', '['+index+']');
        var clone = template.clone().removeClass('hide').removeAttr('id').attr('id', 'list_item_'+index).insertBefore(template);
        clone.find('#sample_input_value').removeAttr('id').attr('name', inputValueName).attr('required', true);
        clone.find('#sample_input_name').removeAttr('id').attr('name', inputLabelName).attr('required', true);
    }

    function removeButton(obj){
        $(obj).parent().parent().remove();
    }
</script>
<?php $this->registerJs("		
	$(document).ready(function(e) {   	   
        $('#".Html::getInputId($model, 'settings[input_type]')."').change(function(){
			if(jQuery.inArray( $(this).val(), ['select', 'checkbox', 'radio'] ) !== -1){
				$('#field_settings_list').removeClass('hide');
				$('#field_settings_list').find('input').removeAttr('disabled');
			} else {
				$('#field_settings_list').addClass('hide');
				$('#field_settings_list').find('input').attr('disabled', true);
			}
		}).trigger('change');
    });
");