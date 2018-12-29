<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\cms\Media */

$this->title = Yii::t('cms/media', 'Update {modelClass}: ', [
    'modelClass' => 'Media',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms/media', 'Media'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('cms/media', 'Update');
?>
<div id="media-update" class="row">
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
