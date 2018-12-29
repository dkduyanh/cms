<?php
use backend\components\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = "User Configuration";
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Configurations'), 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'options' => ['class' => 'form-group'],
        'template' => "{label}\n<div class=\"col-md-6 col-sm-6 col-xs-12\">{input}{hint}</div>\n<div>{error}</div>",
        'labelOptions' => ['class' => 'control-label col-md-3 col-sm-3 col-xs-12'],
        'inputOptions' => ['class' => 'form-control']
    ],
]);?>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">User Configuration</h3>
        </div>
        <div class="box-body">
            <?php echo $form->field($model, 'titles')->textInput();  ?>

            <?php echo $form->field($model, 'showImage')->checkbox(['class' => 'js-switch'], false)->label($model->getAttributeLabel('showImage'));  ?>
            <?php echo $form->field($model, 'defaultImage', [
                'template' => "{label}\n{input}".Html::img(UPLOADS_URL.'/'.$model->defaultImage, ['width' => '175px;'])."[".Html::a('Media', 'javascript:void(0)', ['onclick' => "ElfinderPopup.show({callback: function(file){\$('#".Html::getInputId($model, 'defaultImage')."').val(file.content_path); ElfinderPopup.close();}}); return false;"])."]\n<div>{error}</div>"
            ])->hiddenInput()->label($model->getAttributeLabel('defaultImage'));  ?>

            <?php echo $form->field($model, 'minPasswordLength')->textInput([
                    'type' => 'number',
            ]); ?>
            <?php echo $form->field($model, 'passwordType')->dropDownList([
                'automatic' => 'Automatic',
                'manual' => 'Manual'
            ]);  ?>

            <?php echo $form->field($model, 'allowRegistration')->checkbox(['class' => 'js-switch'], false);  ?>
            <?php echo $form->field($model, 'allowEmailVerification')->checkbox(['class' => 'js-switch'], false);  ?>
            <?php echo $form->field($model, 'allowEmailDomainValidation')->checkbox(['class' => 'js-switch'], false);  ?>
            <?php echo $form->field($model, 'emailDomainWhitelist')->textarea();  ?>
            <?php echo $form->field($model, 'emailDomainBlacklist')->textarea();  ?>
        </div>
    </div>

    <div><button class="btn btn-primary" type="submit">Submit</button></div>

<?php ActiveForm::end() ?>