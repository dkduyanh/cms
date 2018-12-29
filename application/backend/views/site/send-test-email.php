<?php
use yii\helpers\Html;

$this->title = 'Send test email';
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'System'), 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-solid">
    <div class="box-body">
        <h4>Send test email</h4>
        <form class="form-horizontal" method="POST">

            <div class="form-group">
                <label class="control-label col-sm-3">Send a test email to:</label>
                <div class="col-sm-8"><?php echo Html::textInput('email', '', ['class'=> 'form-control', 'required' => true, 'type' => 'email']); ?></div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                    <?php echo Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken); ?>
                    <?php echo Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </form>
    </div>
</div>






