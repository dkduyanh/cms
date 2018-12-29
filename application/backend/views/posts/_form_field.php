<?php
use yii\helpers\Html;
use \yii\helpers\ArrayHelper;
use backend\models\cms\Field;
?>

<?php

	if($model->field->settings && !is_array($model->field->settings)){
		$model->field->settings = json_decode($model->field->settings, true);
	}

	if(isset($model->field->input_type))
	{
		$inputType = $model->field->input_type;
		$inputName = /*$model->formName().*/'PostFields['.$key.'][value]';
		$inputValue = $model->value === null ? $model->field->default_value : $model->value;

		echo $form->field($model, 'field_id')->hiddenInput([
			'name' => 'PostFields['.$key.'][field_id]',
		])->label(false);

		if($inputType == Field::INPUT_TEXT){

			echo $form->field($model, 'value')->textInput([
				'name' => $inputName,
				'value' => $inputValue,
			])->label($model->field->name)->hint($model->field->hint);
		}

		if($inputType == Field::INPUT_SELECT && isset($model->field->settings['list']) && is_array($model->field->settings['list'])){
			echo $form->field($model, 'value')->dropDownList(ArrayHelper::map($model->field->settings['list'], 'value', 'name'), [
				'name' => $inputName,
				'value' => $inputValue,
			])->label($model->field->name)->hint($model->field->hint);
		}

		if($inputType == Field::INPUT_TEXTAREA){
			echo $form->field($model, 'value')->textarea([
				'name' => $inputName,
				'value' => $inputValue,
			])->label($model->field->name)->hint($model->field->hint);
		}

		if($inputType == Field::INPUT_EDITOR){
			echo $form->field($model, 'value', [
				'template' => "{label}\n{input}[".Html::a('Media', 'javascript:void(0)', ['onclick' => "ElfinderPopup.show({callback: function(files){files.forEach(function(file){CKEDITOR.instances['".Html::getInputId($model, '_fields['.$model->field->code.']')."'].insertHtml('<img width=\'100%\' src=\'/uploads/'+file.content_path+'\'>')}); ElfinderPopup.close();}, multiple:true}); return false;"])."]\n<div>{error}</div>"
			])->textarea([
				'name' => $inputName,
				'value' => $inputValue,
				'class' => 'ckeditor'
			])->label($model->field->name)->hint($model->field->hint);
		}

		if($inputType == Field::INPUT_FILE){
			echo $form->field($model, 'value', [
				'template' => "{label}\n{input}[".Html::a('Media', 'javascript:void(0)', ['onclick' => "ElfinderPopup.show({callback: function(file){\$('#".Html::getInputId($model, '_fields['.$model->field->code.']')."').val(file.content_path); ElfinderPopup.close();}}); return false;"])."]\n<div>{error}</div>"
			])->textInput([
				'name' => $inputName,
				'value' => $inputValue,
			])->label($model->field->name)->hint($model->field->hint);
		}
}