<?php
use backend\components\widgets\ActiveForm;
use \backend\models\ContactInfoConfigurationForm;

$this->title = "Contact Information";
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
            <h3 class="box-title">Contact Information</h3>
        </div>
        <div class="box-body">
            <?php echo $form->field($model, 'headline')->textInput();  ?>
            <?php echo $form->field($model, 'about')->textarea();  ?>

            <?php echo $form->field($model, 'person')->textInput();  ?>
            <?php echo $form->field($model, 'address')->textInput();  ?>
            <?php echo $form->field($model, 'city')->textInput();  ?>
            <?php echo $form->field($model, 'zip')->textInput();  ?>
            <?php echo $form->field($model, 'email')->textInput();  ?>
            <?php echo $form->field($model, 'phone')->textInput();  ?>
            <?php echo $form->field($model, 'mobile')->textInput();  ?>
            <?php echo $form->field($model, 'fax')->textInput();  ?>
            <?php echo $form->field($model, 'website')->textInput();  ?>

            <?php echo $form->field($model, 'salesEmail')->textInput();  ?>
            <?php echo $form->field($model, 'technicalEmail')->textInput();  ?>

            <?php /*
            <hr>
            <div><small>Extras:</small></div>

            <?php foreach($model->extras as $i => $e): ?>
                <?php echo $form->field($model, "extras[{{$i}][{$e['value']}]")->textInput()->label($e['field']);  ?>
            </div>
            <?php endforeach; ?>
            <div class="form-group field-contactinfoconfigurationform-website">
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?php echo $form->field($model, 'extras[][field]')->textInput();  ?>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php echo $form->field($model, 'extras[][value]')->textInput();  ?>
                </div>
                <div><p class="help-block help-block-error"></p></div>
            </div>
            */?>

            <hr>
            <div><small>Social media:</small></div>
            <?php foreach(ContactInfoConfigurationForm::listSupportedSocialMedia() as $item): ?>
            <?php echo $form->field($model, 'socialmedia['.$item.']')->textInput()->label(ucfirst($item));  ?>
            <?php endforeach; ?>
        </div>
    </div>

    <div><button class="btn btn-primary" type="submit">Submit</button></div>

<?php ActiveForm::end() ?>