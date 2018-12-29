<?php

use yii\helpers\Html;
use backend\components\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\main\Role */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('role', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="role-view" class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo Html::encode($this->title) ?></h3>
            </div>
            <div class="box-body">
                <p>
                	<?php echo \backend\components\helpers\AdminHelper::backButton(['index']); ?>
                    <?php echo \backend\components\helpers\AdminHelper::createLinkButton(['permissions/role', 'id' => $model->id], Yii::t('acl', 'Permissions'), 'key', 'btn btn-warning'); ?>
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
                        'created_date',
                        'last_modified_date',
                        'is_admin',
                        'is_default',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
