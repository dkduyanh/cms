<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('common', 'Change password');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'System'), 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-solid">
    <div class="box-body">
        <?php $form = ActiveForm::begin([
            'id' => 'user-form',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'options' => ['class' => 'form-group item'],
                'template' => "{label}\n<div class=\"col-md-6 col-sm-6 col-xs-12\">{input}</div>\n<div>{error}</div>",
                'labelOptions' => ['class' => 'control-label col-md-3 col-sm-3 col-xs-12'],
                'inputOptions' => ['class' => 'form-control col-md-7 col-xs-12']
            ],
        ]);?>

            <h4><?php echo Yii::t('users', 'Change Password'); ?></h4>

            <?php echo $form->field($model, 'currentPassword')->passwordInput()?>
            <?php echo $form->field($model, 'newPassword')->passwordInput()?>
            <?php echo $form->field($model, 'confirmNewPassword')->passwordInput()?>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                    <?php echo Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
