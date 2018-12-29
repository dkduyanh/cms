<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = "Basic Settings";
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
            <h3 class="box-title">Site Information</h3>
        </div>
        <div class="box-body">
            <?php if(isset($models['general.site_title'])):?>
                <?php echo $form->field($models['general.site_title'], 'value')->textInput(['name' => 'general.site_title'])->label('Site Title');  ?>
            <?php endif; ?>
            <?php if(isset($models['general.site_description'])):?>
                <?php echo $form->field($models['general.site_description'], 'value')->textInput(['name' => 'general.site_description'])->label('Site Description');  ?>
            <?php endif; ?>
            <?php if(isset($models['general.site_keywords'])):?>
                <?php echo $form->field($models['general.site_keywords'], 'value')->textInput(['name' => 'general.site_keywords'])->label('Site Keywords');  ?>
            <?php endif; ?>
            <?php if(isset($models['general.site_url'])):?>
                <?php echo $form->field($models['general.site_url'], 'value')->textInput(['name' => 'general.site_url'])->label('Site URL');  ?>
            <?php endif; ?>
        </div>
    </div>


    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">SMTP Mailer Settings</h3>
        </div>
        <div class="box-body">
            <?php if(isset($models['general.smtp.server'])):?>
                <?php echo $form->field($models['general.smtp.server'], 'value')->textInput()->label('Server');  ?>
            <?php endif; ?>
            <?php if(isset($models['general.smtp.port'])):?>
                <?php echo $form->field($models['general.smtp.port'], 'value')->textInput()->label('Port');  ?>
            <?php endif; ?>
            <?php if(isset($models['general.smtp.encryption'])):?>
                <?php echo $form->field($models['general.smtp.encryption'], 'value')->dropDownList([
                    '' => 'None',
                    'ssl' => 'SSL',
                    'tls' => 'TLS',
                ])->label('Encryption');  ?>
            <?php endif; ?>
            <?php if(isset($models['general.smtp.user'])):?>
                <?php echo $form->field($models['general.smtp.user'], 'value')->textInput()->label('User');  ?>
            <?php endif; ?>
            <?php if(isset($models['general.smtp.password'])):?>
                <?php echo $form->field($models['general.smtp.password'], 'value')->textInput()->label('Password');  ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Date/Time</h3>
        </div>
        <div class="box-body">
            <?php if(isset($models['general.timezone'])):?>
                <?php echo $form->field($models['general.timezone'], 'value')->dropDownList(\common\library\Utils::getTimezones())->label('Timezone');  ?>
            <?php endif; ?>
            <?php if(isset($models['general.date_format'])):?>
                <?php echo $form->field($models['general.date_format'], 'value')->textInput()->label('Date Format');  ?>
            <?php endif; ?>
            <?php if(isset($models['general.time_format'])):?>
                <?php echo $form->field($models['general.time_format'], 'value')->textInput()->label('Time Format');  ?>
            <?php endif; ?>
        </div>
    </div>


    <div><button class="btn btn-primary" type="submit">Submit</button></div>

<?php ActiveForm::end() ?>