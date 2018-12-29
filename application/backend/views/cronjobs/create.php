<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\main\Cronjob */

$this->title = Yii::t('acl', 'Create Cronjob');
$this->params['breadcrumbs'][] = ['label' => Yii::t('acl', 'Cronjobs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="cronjob-create" class="row">
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
