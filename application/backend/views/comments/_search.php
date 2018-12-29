<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CommentList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'post_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'body') ?>

    <?= $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'creator_id') ?>

    <?php // echo $form->field($model, 'creator_name') ?>

    <?php // echo $form->field($model, 'creator_email') ?>

    <?php // echo $form->field($model, 'creator_ip') ?>

    <?php // echo $form->field($model, 'last_modified_date') ?>

    <?php // echo $form->field($model, 'last_modifier_id') ?>

    <?php // echo $form->field($model, 'like_count') ?>

    <?php // echo $form->field($model, 'dislike_count') ?>

    <?php // echo $form->field($model, 'parent_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('cms/comment', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('cms/comment', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
