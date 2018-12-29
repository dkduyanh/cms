<?php

use yii\helpers\Html;
use backend\components\widgets\ActiveForm;
use backend\models\cms\Category;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\cms\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">
	<?php $form = ActiveForm::begin(); ?>
	<ul id="navigation" class="nav nav-tabs" role="tablist">
        <li class="active"><a data-toggle="tab" href="#main-form" aria-expanded="true">Main</a></li>
        <li class=""><a data-toggle="tab" href="#settings-form" aria-expanded="false">Settings</a></li>
    </ul>
    <div class="tab-content" style="margin-top:15px;">
        <div id="main-form" class="tab-pane active">
		    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'description')->textarea(['maxlength' => true, 'rows' => 5]) ?>
		    <?php echo $form->field($model, 'image', [
				'template' => "{label}\n<div class=\"col-sm-6 col-xs-12\">{input}[".Html::a('Media', 'javascript:void(0)', ['onclick' => "ElfinderPopup.show({callback: function(file){\$('#".Html::getInputId($model, 'image')."').val(file.content_path); ElfinderPopup.close();}}); return false;"])."]</div>\n<div>{error}</div>"
			])->textInput(['maxlength' => true]) ?>		
		    <?php echo $form->field($model, 'image_alt')->textInput(['maxlength' => true]) ?>		
		    <?php echo $form->field($model, 'position')->textInput()->hint('Items are displayed in ascending order by position.') ?>
		    <?php echo $form->field($model, 'is_sticky')->checkbox(['class' => 'js-switch'], false) ?>		
		    <?php echo $form->field($model, 'parent_id')->dropDownList(ArrayHelper::map(Category::listAllInTree('--', $model->id), 'id', 'name'), [
		        'prompt'=>Yii::t('common', ''),
		        'data-live-search' => "true",
		        'class' => 'form-control selectpicker',
		        'data-style' => "btn-primary",
		        'data-width' => '100%',
		    ]); ?>
		    <?php echo $form->field($model, 'status')->dropDownList(Category::statusLabels()) ?>
		</div>
		<div id="settings-form" class="tab-pane">
           <?php echo $this->render('/layouts/common/_extras_seo', ['form' => $form, 'model' => $model]); ?>
           <?php echo $this->render('/layouts/common/_extras_appearance', ['form' => $form, 'model' => $model]); ?>
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
