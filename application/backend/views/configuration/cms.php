<?php
use backend\components\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = "Content Configuration";
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Configurations'), 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'options' => ['class' => 'form-group'],
        'template' => "{label}\n<div class=\"col-md-6 col-sm-6 col-xs-12\">{input}</div>\n<div>{error}</div>",
        'labelOptions' => ['class' => 'control-label col-md-3 col-sm-3 col-xs-12'],
        'inputOptions' => ['class' => 'form-control']
    ],
]);?>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Content</h3>
    </div>
    <div class="box-body">
        <?php echo $form->field($model, 'postDefaultImage', [
            'template' => "{label}\n{input}".Html::img(UPLOADS_URL.'/'.$model->postDefaultImage, ['width' => '175px;'])."[".Html::a('Media', 'javascript:void(0)', ['onclick' => "ElfinderPopup.show({callback: function(file){\$('#".Html::getInputId($model, 'postDefaultImage')."').val(file.content_path); ElfinderPopup.close();}}); return false;"])."]\n<div>{error}</div>"
        ])->hiddenInput()->label($model->getAttributeLabel('postDefaultImage'));  ?>
        <?php echo $form->field($model, 'postEditor')->dropDownList(['None', 'CKEditor', 'tinyMCE']);  ?>
        <?php echo $form->field($model, 'postEditorContentCss')->textarea(); ?>
        <hr>
        <h4>Duplicate</h4>
        <?php echo $form->field($model, 'postDuplicateTitlePrefix')->textInput();  ?>
        <?php echo $form->field($model, 'postDuplicateTitleSuffix')->textInput();  ?>
        <?php echo $form->field($model, 'postDuplicateStatus')->dropDownList( \yii\helpers\ArrayHelper::merge([
            '' => 'Same as source',
        ], \backend\models\cms\Post::statusLabels()));  ?>
    </div>
</div>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Comments</h3>
    </div>
    <div class="box-body">
        <?php echo $form->field($model, 'allowGuestComment')->checkbox(['class' => 'js-switch'], false);  ?>
        <?php echo $form->field($model, 'commentModeration')->checkbox(['class' => 'js-switch'], false);  ?>


    </div>
</div>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Media</h3>
    </div>
    <div class="box-body">
        <?php echo $form->field($model, 'mediaThumbSize')->textInput();  ?>
    </div>
</div>


<div><button class="btn btn-primary" type="submit">Submit</button></div>

<?php ActiveForm::end() ?>
