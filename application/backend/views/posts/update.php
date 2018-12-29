<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\cms\Post */

$this->title = Yii::t('cms/post', 'Update {postType}: ', [
    'postType' => $model->post->type->name,
]) . $model->post->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms/post', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->post->title, 'url' => ['view', 'id' => $model->post->id]];
$this->params['breadcrumbs'][] = Yii::t('cms/post', 'Update');
?>
<div id="post-update" class="row">
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
