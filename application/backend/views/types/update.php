<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\cms\Type */

$this->title = Yii::t('cms/types', 'Update {modelClass}: ', [
    'modelClass' => 'Type',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms/types', 'Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('cms/types', 'Update');
?>
<div id="type-update" class="row">
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
