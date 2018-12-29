<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\main\EmailTemplate */

$this->title = Yii::t('email_template', 'Update {modelClass}: ', [
    'modelClass' => 'Email Template',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('email_template', 'Email Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('email_template', 'Update');
?>
<div id="email-template-update" class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo Html::encode($this->title) ?></h3>
            </div>
            <div class="box-body">
                <?php echo $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>
