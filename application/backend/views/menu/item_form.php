<?php

use yii\helpers\Html;
use backend\components\widgets\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model backend\models\main\Menu */

$this->title = $model->isNewRecord ? Yii::t('menu', 'Create new item') : Yii::t('menu', 'Update {modelClass}: ', [
        'modelClass' => 'Menu Item',
    ]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('menu', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $menuModel->name, 'url' => ['view', 'id' => $menuModel->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('menu', 'Menu Items'), 'url' => ['items', 'id' => $menuModel->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="item-menu-update" class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo Html::encode($this->title) ?></h3>
            </div>
            <div class="box-body">
                <div class="menu-form">

                    <?php $form = ActiveForm::begin([
                        'options' => ['class' => ''],
                        'fieldConfig' => [
                            'options' => ['class' => 'form-group'],
                            'template' => "{label}\n{input}{hint}\n<div>{error}</div>",
                            'labelOptions' => ['class' => 'control-label'],
                            'inputOptions' => ['class' => 'form-control']
                        ],
                    ]); ?>

                    <ul id="navigation" class="nav nav-tabs" role="tablist">
                        <li class="active"><a data-toggle="tab" href="#main-form" aria-expanded="true">Main</a></li>
                        <li class=""><a data-toggle="tab" href="#settings-form" aria-expanded="false">Settings</a></li>
                    </ul>
                    <div class="tab-content" style="margin-top:15px;">
                        <div id="main-form" class="tab-pane active">
                            <div class="row">
                                <div class="col-sm-9">
                                    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                                    <?php echo $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
                                    <hr>
                                    <?php echo $form->field($model, 'type')->dropDownList(\backend\models\main\MenuItem::listTypes());?>

                                    <div id="itemForm"></div>
                                    <div id="itemParams">
                                        <?php echo $form->field($model, 'link')->textInput(); ?>
                                        <?php echo $form->field($model, 'route')->textInput(); ?>
                                        <?php echo $form->field($model, 'params')->textarea(); ?>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <?php echo $form->field($model, 'language')->dropDownList(\yii\helpers\ArrayHelper::map(\backend\models\main\Language::listAll(), 'code', 'name'), [
                                        'prompt' => '',
                                    ]); ?>
                                    <?php echo $form->field($model, 'target')->dropDownList([
                                        '_self' => '_self',
                                        '_blank' => '_blank',
                                        '_parent' => '_parent',
                                    ])?>
                                    <?php echo $form->field($model, 'parent_id')->dropDownList($menuModel->listItemsDropdown(), [
                                        'prompt' => '',
                                    ]); ?>
                                    <?php echo $form->field($model, 'position')->textInput(['type' => 'number']); ?>
                                    <?php echo $form->field($model, 'status')->dropDownList(\backend\models\main\MenuItem::statusLabels()) ?>
                                </div>
                            </div>


                        </div>
                        <div id="settings-form" class="tab-pane">


                            <?php /* echo $form->field($model, 'type')->dropDownList([
                    		'System' => ['url' => 'Custom URL', 'email' => 'Email', 'login' => 'Login', 'logout' => 'Logout'],
                    		'CMS' => [
                    			'single_post' => 'Single Post',
                    			Url::to(['categories/index']) => 'Category',
                    			Url::to(['tags/index']) => 'Tag'],
                    ]);*/ ?>

                            <?php //echo $this->render('form_elements/_extras', ['form' => $form, 'model' => $model]); ?>

                        </div>
                    </div>

                    <div class="form-group">
                    	<div class="col-md-6 col-md-offset-3">
                            <?php echo \backend\components\helpers\AdminHelper::submitButton(); ?>
                            <?php echo \backend\components\helpers\AdminHelper::cancelButton(['items', 'id' => $model->menu->id]); ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>



<?php
\yii\bootstrap\Modal::begin([
    'header' => '<h2>Hello world</h2>',
    'toggleButton' => ['label' => 'click me', 'value' => \yii\helpers\Url::to(['posts/index', 'type' => 1])],
]);

echo '<div style="text-align:center"><img src="https://loading.io/spinners/spin/index.ajax-spinner-gif.svg"></div>';

\yii\bootstrap\Modal::end();
?>




<?php 
$this->registerCss("
.mfp-inline-holder .mfp-content, .mfp-ajax-holder .mfp-content {
  	width:70%;
	height:80%;
}		
");
$this->registerJs("
	var elType = $('#".Html::getInputId($model, 'type')."');	
	elType.trigger('change');
	$(elType).change(function(){
	    $.ajax({
		  method: 'POST',
		  url: '".\yii\helpers\Url::to(['load-item-form', 'type' => ''])."'+$(this).val(),
		  data: { },
		  type: 'html',
		}).done(function( msg ) {
		    $('#itemForm').html(msg);
		});
	});	
		
		


	var popup;
    function selectRefId() {
        /* popup = window.open(elType.val(), 'Popup', 'width=800px,height=800px');
        popup.focus();
        return false */

		$.ajax({
		  method: 'POST',
		  url: '".\yii\helpers\Url::to(['posts/index', 'type' => 1])."',
		  data: { }
		}).done(function( msg ) {
		    $.magnificPopup.open({
			  items: {
			    src: msg
			  },
			  type: 'inline'
			});
		
			/*$('a').click(function(){
				return false;
			});*/
		});
    }	
", View::POS_END);
?>