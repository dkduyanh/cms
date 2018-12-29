<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\cms\Post */

$this->title = Yii::t('cms/post', 'Create New');
$this->params['breadcrumbs'][] = 'Contents';
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms/post', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="post-create" class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <small>Contents &raquo; </small>
                    <small><?php echo Html::a($model->post->type->name, ['index', 'type' => $model->post->type->id]); ?> &raquo; </small>
                    <?php echo Html::encode($this->title) ?>
                </h3>
            </div>
            <div class="box-body">
                <?php echo $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>
