<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\main\EmailTemplate */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('email_template', 'Email Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="email-template-view" class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo Html::encode($this->title) ?></h3>
            </div>
            <div class="box-body">

                <p>
                    <?php echo \backend\components\helpers\AdminHelper::backButton(['index']); ?>
                    <?php echo \backend\components\helpers\AdminHelper::editButton(['update', 'id' => $model->id]); ?>
                    <?php echo \backend\components\helpers\AdminHelper::deleteButton(['delete', 'id' => $model->id]); ?>
                </p>

                <?php echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'code',
                        'name',
                        'description',
                        'subject',
                        'body:ntext',
                        'sender_email:email',
                        'sender_name',
                        'created_date',
                        'creator_id',
                        'last_modified_date',
                        'last_modifier_id',
                        'allow_delete',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
