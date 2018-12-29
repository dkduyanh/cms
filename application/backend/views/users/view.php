<?php

use yii\helpers\Html;
use backend\components\widgets\DetailView;
use backend\models\main\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="user-view" class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo Html::encode($this->title) ?></h3>
            </div>
            <div class="box-body">
                <p>
                    <?php echo \backend\components\helpers\AdminHelper::backButton(['index']); ?>
                    <?php echo \backend\components\helpers\AdminHelper::createLinkButton(['permissions/user', 'id' => $model->id], Yii::t('acl', 'Permissions'), 'key', 'btn btn-warning'); ?>
                    <?php echo \backend\components\helpers\AdminHelper::editButton(['update', 'id' => $model->id]); ?>
                    <?php echo \backend\components\helpers\AdminHelper::deleteButton(['delete', 'id' => $model->id]); ?>
                </p>
                <?php echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'code',
                        'username',
                        'email:email',
                        'phone',
                        'firstname',
                        'lastname',
                        'fullname',
                        'displayname',
                        'gender',
                        'birthdate',
                        'birthplace',
                        [
                            'attribute' => 'image',
                            'format' => 'html',
                            'value' => Html::img($model->getImageUrl())
                        ],
                        'title',
                        'about_me:ntext',
                        'description',
                        'creator_id',
                        'created_date',
                        'last_modifier_id',
                        'last_modified_date',
                        'last_password_changed_date',
                        'last_login_date',
                        'last_access_date',
                        'last_verified_date',
                        'timezone',
                        'language',
                        [
                            'attribute' => 'verified',
                            'value' => $model->getVerifiedStatusLabel()
                        ],
                        [
                        	'attribute' => 'status',
                        	'format' => 'html',
                        	'value' => function($model){
                    			$class = 'label-danger';
                    			if($model->isActive()){
                    			    $class = 'label-success';
                    			}
                        		return Html::tag('span', $model->statusLabel, ['class' => "label {$class}"]);
                    		}
                        ],
                        'settings:ntext',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>