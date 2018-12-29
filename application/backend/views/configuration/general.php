<?php
use backend\components\widgets\ActiveForm;
use yii\bootstrap\Html;

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
            <?php echo $form->field($model, 'siteName')->textInput()->label('Site Name');  ?>
            <?php echo $form->field($model, 'siteUrl')->textInput()->label('Site URL');  ?>

            <?php echo $form->field($model, 'siteLogo', [
                'template' => "{label}\n{input}".Html::img(UPLOADS_URL.'/'.$model->siteLogo, ['width' => '175px;'])."[".Html::a('Media', 'javascript:void(0)', ['onclick' => "ElfinderPopup.show({callback: function(file){\$('#".Html::getInputId($model, 'siteLogo')."').val(file.content_path); ElfinderPopup.close();}}); return false;"])."]\n<div>{error}</div>"
            ])->hiddenInput()->label('Site Logo');  ?>

            <?php echo $form->field($model, 'siteIcon', [
                'template' => "{label}\n{input}".Html::img(UPLOADS_URL.'/'.$model->siteIcon, ['width' => '64px;'])."[".Html::a('Media', 'javascript:void(0)', ['onclick' => "ElfinderPopup.show({callback: function(file){\$('#".Html::getInputId($model, 'siteFavicon')."').val(file.content_path); ElfinderPopup.close();}}); return false;"])."]\n<div>{error}</div>"
            ])->hiddenInput()->label('Site Icon');  ?>

            <?php echo $form->field($model, 'siteOffline')->checkbox(['class' => 'js-switch'], false)->label('Site Offline');  ?>
            <?php echo $form->field($model, 'siteOfflineMessage')->textarea()->label('Offline Message');  ?>

            <?php echo $form->field($model, 'siteCopyright')->textInput(); ?>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Regional and language</h3>
        </div>
        <div class="box-body">
            <?php echo $form->field($model, 'timezone')->dropDownList(\common\library\Utils::getTimezones())->label('Timezone');  ?>
            <?php echo $form->field($model, 'dateFormat')->dropDownList([
                    'd/m/Y' => 'd/m/Y ('.date('d/m/Y').')',
                    'Y-m-d' => 'Y-m-d ('.date('Y-m-d').')',
                    'F j, Y' => 'F j, Y ('.date('F j, Y').')',

            ])->label('Date Format');  ?>
            <?php echo $form->field($model, 'timeFormat')->dropDownList([
                    'H:i:s' => 'H:i:s ('.date('H:i:s').')',
                    'g:i a' => 'g:i a ('.date('g:i a').')',
                    'g:i A' => 'g:i A ('.date('g:i A').')',
                    'H:i' => 'H:i ('.date('H:i').')',
            ])->label('Time Format');  ?>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Metadata / SEO</h3>
        </div>
        <div class="box-body">
            <?php echo $form->field($model, 'metaDescription')->textInput()->label('Meta Description');  ?>
            <?php echo $form->field($model, 'metaKeywords')->textInput()->label('Meta Keywords');  ?>
            <?php echo $form->field($model, 'metaRobots')->dropDownList([
                '' => '',
                'index, follow' => 'Index, Follow',
                'noindex, follow' => 'No index, follow',
                'index, nofollow' => 'Index, No follow',
                'noindex, nofollow' => 'No index, no follow',
            ])->label('Meta Robots');  ?>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">SMTP Mailer Settings</h3>
        </div>
        <div class="box-body">
            <?php echo $form->field($model, 'smtpServer')->textInput()->label('Server');  ?>
            <?php echo $form->field($model, 'smtpPort')->textInput()->label('Port');  ?>
            <?php echo $form->field($model, 'smtpEncryption')->dropDownList([
                '' => 'None',
                'ssl' => 'SSL',
                'tls' => 'TLS',
            ])->label('Encryption');  ?>
            <?php echo $form->field($model, 'smtpAuthentication')->checkbox([
                'class' => 'js-switch'
            ], false)->label('Encryption');  ?>
            <?php echo $form->field($model, 'smtpUser')->textInput()->label('User');  ?>
            <?php echo $form->field($model, 'smtpPassword')->passwordInput()->label('Password');  ?>
        </div>
    </div>

    <div><button class="btn btn-primary" type="submit">Submit</button></div>

<?php ActiveForm::end() ?>