<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\cms\Comment */

$this->title = Yii::t('cms/comment', 'Update {modelClass}: ', [
    'modelClass' => 'Comment',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms/comment', 'Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('cms/comment', 'Update');
?>
<div id="comment-update" class="row">
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
