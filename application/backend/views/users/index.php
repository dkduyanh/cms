<?php

use yii\helpers\Html;
use backend\components\widgets\GridView;
use yii\widgets\Pjax;
use backend\models\main\User;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('user', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="user-index" class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header"><h3 class="box-title"><?php echo Html::encode($this->title) ?></h3></div>
            <div class="box-body">
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                <p>
                    <?php echo \backend\components\helpers\AdminHelper::createButton(['create']); ?>
                </p>
                <?php Pjax::begin(); ?>
                <?php echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'name'  => 'id',
                            'headerOptions' => ['width' => '30px'],
                        ],
                        //['class' => 'yii\grid\SerialColumn'],

                        //'id',
                        [
                            'attribute' => 'username',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) {
                                return Html::a(Html::img($model->defaultImage, ['width' => '32px']), ['view', 'id' => $model->id], ['data-pjax' => "0"]).' '.$model->username;
                            },
                            //'filter' => false,
                        ],
                        [
                            'attribute' => 'firstname',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) {
                                return isset($model->lastname)?Html::a($model->firstname, ['view', 'id' => $model->id], ['data-pjax' => "0"]):null;
                            },
                            'headerOptions' => ['width' => '120px'],
                        ],
                        [
                            'attribute' => 'lastname',
                            'format' => 'raw',
                            'value' => function ($model, $key, $index, $column) {
                                return isset($model->lastname)?Html::a($model->lastname, ['view', 'id' => $model->id], ['data-pjax' => "0"]):null;
                            },
                            'headerOptions' => ['width' => '120px'],
                        ],
                        //'code',
                        //'email:email',
                        // 'phone',
                        // 'password',
                        // 'firstname',
                        // 'lastname',
                        // 'fullname',
                        // 'displayname',
                        // 'gender',
                        // 'birthdate',
                        // 'birthplace',
                        // 'image',
                        // 'title',
                        // 'about_me:ntext',
                        // 'description',
                        // 'creator_id',
                        // 'created_date',
                        // 'last_modifier_id',
                        // 'last_modified_date',
                        // 'last_password_changed_date',
                        // 'last_login_date',
                        // 'last_access_date',
                        // 'last_verified_date',
                        // 'timezone',
                        // 'language',
                        // 'verified',
                        [
                                'label' => 'Roles',
                                'format' => 'html',
                                'value' => function ($model, $key, $index, $column) {
                                    $roles = [];
                                    foreach($model->roles as $role){
                                        $roles[] = $role->name;
                                    }
                                    return implode(', ', $roles);
                                }
                        ],
                        [
                        	'attribute' => 'status',
                        	'format' => 'html',
                        	'value' => function ($model, $key, $index, $column) {
                        		$class = 'label-danger';
                        		if($model->isActive()){
                        		    $class = 'label-success';
                        		}
                        		return Html::tag('span', $model->statusLabel, ['class' => "label {$class}"]);
                        	},
                        	'filter' => User::statusLabels(),
	                        'headerOptions' => ['width' => '90px'],
                        ],
                        // 'settings:ntext',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'headerOptions' => ['width' => '75px'],
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>