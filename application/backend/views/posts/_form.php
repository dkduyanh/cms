<?php

use yii\helpers\Html;
use backend\components\widgets\ActiveForm;
use backend\models\cms\Category;
use yii\helpers\ArrayHelper;
use backend\models\cms\Post;
use \common\models\main\Language;
use backend\models\cms\Field;

/* @var $this yii\web\View */
/* @var $model common\models\cms\Post */
/* @var $form yii\widgets\ActiveForm */

backend\assets\CKEditorAsset::register($this);
?>

<div class="post-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => ''],
        'fieldConfig' => [
            'options' => ['class' => 'form-group'],
            'template' => "{label}\n{input}{hint}\n<div>{error}</div>",
            'labelOptions' => ['class' => 'control-label'],
            'inputOptions' => ['class' => 'form-control']
        ],
    ]); ?>
	<?php echo $model->errorSummary($form); ?>
    <ul id="navigation" class="nav nav-tabs" role="tablist">
        <li class="active"><a data-toggle="tab" href="#main-form" aria-expanded="true">Main</a></li>
        <li class=""><a data-toggle="tab" href="#settings-form" aria-expanded="false">Settings</a></li>
    </ul>
    <div class="tab-content" style="margin-top:15px;">
        <div id="main-form" class="tab-pane active">
            <div class="row">
                <div class="col-sm-9">
                    <?php if($model->post->type->show_title): ?>
                        <?php echo $form->field($model->post, 'title')->textInput(['maxlength' => true]) ?>
                    <?php endif; ?>

                    <?php if($model->post->type->show_intro): ?>
                        <?php echo $form->field($model->post, 'intro')->textarea(['rows' => 6]) ?>
                    <?php endif; ?>

                    <?php if($model->post->type->show_body): ?>
                        <?php echo $form->field($model->post, 'body',[
                            'template' => "{label}\n{input}[".Html::a('Media', 'javascript:void(0)', ['onclick' => "ElfinderPopup.show({callback: function(files){files.forEach(function(file){CKEDITOR.instances['".Html::getInputId($model->post, 'body')."'].insertHtml('<img width=\'100%\' src=\'/uploads/'+file.content_path+'\'>')}); ElfinderPopup.close();}, multiple:true}); return false;"])."]\n<div>{error}</div>"
                        ])->textarea(['rows' => 6]) ?>
                    <?php endif; ?>

                    <?php if($model->post->type->show_image): ?>
                        <?php echo $form->field($model->post, 'image', [
                            'template' => "{label}\n{input}[".Html::a('Media', 'javascript:void(0)', ['onclick' => "ElfinderPopup.show({callback: function(file){\$('#".Html::getInputId($model->post, 'image')."').val(file.content_path).trigger('change'); ElfinderPopup.close();}}); return false;"])."] [<a href='javascript:void(0);' onclick=\"$('#".Html::getInputId($model->post, 'image')."').val('').trigger('change');\">Clear</a>]\n<div>{error}</div>"
                        ])->hiddenInput(['maxlength' => true]) ?>
                        <?php echo Html::img($model->post->getImageUrl(), ['style' => 'max-height:120px; max-height:120px', 'id' => 'thumb-'.Html::getInputId($model->post, 'image')]); ?>
                    <?php endif; ?>

                    <?php if($model->post->type->show_image_alt): ?>
                        <?php echo $form->field($model->post, 'image_alt', [
                            'template' => "{label}\n{input}[".Html::a('Media', 'javascript:void(0)', ['onclick' => "ElfinderPopup.show({callback: function(file){\$('#".Html::getInputId($model->post, 'image_alt')."').val(file.content_path); ElfinderPopup.close();}}); return false;"])."]\n<div>{error}</div>"
                        ])->textInput(['maxlength' => true]) ?>
                    <?php endif; ?>

                    <!-- Custom Fields -->
                    <?php if(!empty($model->postFields)): ?>
                    <hr>
                    <h4>Custom fields</h4>
                    <?php foreach($model->postFields as $key => $postField): ?>
                        <?php echo $this->render('_form_field', ['key' => $key, 'model' => $postField, 'form' => $form]); ?>
                    <?php endforeach; ?>
                    <?php endif; ?>

                </div>
                <div class="col-sm-3">
                    <?php echo $form->field($model->post, 'code')->textInput(['maxlength' => true]) ?>
                    <?php if($model->post->type->show_categories): ?>
                        <?php echo $form->field($model, 'categories')->dropDownList(ArrayHelper::map(Category::listAllInTree(), 'id', 'name'), [
                            'multiple' => 'multiple',
                            /*'data-live-search' => "true",
                            'class' => 'selectpicker form-control',
                            'data-style' => "btn-primary",
                            'data-width' => '100%',*/
                        ]) ?>
                    <?php endif; ?>
                    <?php if($model->post->type->show_tags): ?>
                        <?php echo $form->field($model, 'tags')->textInput(['maxlength' => true])->hint('Enter a comma-separated list. For example: Amsterdam, Mexico City, "Cleveland, Ohio" ') ?>
                    <?php endif; ?>
                    <?php if(($langs = Language::listAll()) !== null): ?>
                        <?php echo $form->field($model->post, 'language')->dropDownList( ArrayHelper::map($langs, 'code', 'name'), [
                                'prompt' => ''
                        ]); ?>
                    <?php endif; ?>
                    <?php echo $form->field($model->post, 'allow_comment')->checkbox(['class' => 'js-switch'], false)->hint('Allow users to post comments.'); ?>
                    <?php echo $form->field($model->post, 'allow_search')->checkbox(['class' => 'js-switch'], false)->hint('Allow users to search this post.'); ?>
                    <?php echo $form->field($model->post, 'is_sticky')->checkbox(['class' => 'js-switch'], false)->hint('Sticky at top of lists or front-page.'); ?>
                    <?php echo $form->field($model->post, 'position')->textInput(['type' => 'number']) ?>
                    <?php echo $form->field($model->post, 'published_date')->textInput(); ?>
                    <?php echo $form->field($model->post, 'expiry_date')->textInput(); ?>
                    <?php echo $form->field($model->post, 'status')->dropDownList(Post::statusLabels()) ?>
                    <hr>
	                <?php echo $form->field($model, '_template')->textInput() ?>
                </div>
            </div>


        </div>
        <div id="settings-form" class="tab-pane">
            <div class="panel panel-default">
                <div class="panel-heading strong"><i class="fa fa-search"></i> SEO</div>
                <div class="panel-body">

                    <?php echo $form->field($model->post, 'extras[seo][title]')->textInput()->label('Meta Title'); ?>
                    <?php echo $form->field($model->post, 'extras[seo][keywords]')->textInput()->label('Meta Keywords'); ?>
                    <?php echo $form->field($model->post, 'extras[seo][description]')->textInput()->label('Meta Description'); ?>
                    <?php echo $form->field($model->post, 'extras[seo][robots]')->textInput()->label('Robots'); ?>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading strong"><i class="fa fa-paint-brush"></i> Appearance</div>
                <div class="panel-body">
                    <?php echo $form->field($model->post, 'extras[appearance][class]')->textInput()->label('Class'); ?>
                    <?php echo $form->field($model->post, 'extras[appearance][style]')->textInput()->label('CSS'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <?php echo \backend\components\helpers\AdminHelper::submitButton(); ?>
            <?php if($model->post->isNewRecord): ?>
                <?php echo \backend\components\helpers\AdminHelper::cancelButton(['index', 'type' => $model->post->type_id]); ?>
            <?php else: ?>
                <?php echo Html::a(Yii::t('common', 'Save as Copy'), ['duplicate', 'id' => $model->post->id], ['class' => 'btn btn-success', 'data-method' => 'POST']) ?>
                <?php echo \backend\components\helpers\AdminHelper::cancelButton(['view', 'id' => $model->post->id]); ?>
            <?php endif; ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->registerJs("
var externalCssBundle = ".(new \common\models\CmsConfiguration)->getpostEditorContentCss().";
CKEDITOR.replace('".Html::getInputName($model->post, 'body')."', {
	toolbar: [
		{ name: 'document', items: [ 'Source'] },
		{ name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
		{ name: 'editing', items: [ 'Find', 'Replace'] },
		'/',
		{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
		{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] },
		{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
		{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
		'/',
		{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] }
	],
	allowedContent: true,
	contentsCss: [CKEDITOR.basePath + 'contents.css'].concat(externalCssBundle)
}); 
$(document).ready(function() {
    $('#".Html::getInputId($model, 'categories')."').select2();
    $('#".Html::getInputId($model->post, 'published_date')."').datepicker();
    $('#".Html::getInputId($model->post, 'expiry_date')."').datepicker();
    
    var imgFieldId = '".Html::getInputId($model->post, 'image')."';
    var UPLOADS_URL = '".UPLOADS_URL."';
    $('#'+imgFieldId).change(function(){
        $('#thumb-'+imgFieldId).attr('src', UPLOADS_URL+'/'+$(this).val());
    });
});
");
?>