<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use backend\components\widgets\ActiveForm;

$this->title = Yii::t('acl', 'Role Permissions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="acl-action-index" class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header"><h3 class="box-title"><?php echo Html::encode($this->title) ?></h3></div>
            <div class="box-body">
                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <?php $form = ActiveForm::begin(); ?>
                <table class="table table-condensed">
                	<thead>
                	 	<tr>
                            <th style="width: 10px">#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th style="width: 40px">Allow</th>
                        </tr>
                	</thead>
                    <tbody>
                       <?php foreach($permList as $i => $perm):?>
                        <tr data-key="<?php echo $perm->id; ?>">
                            <td><?php echo $i+1; ?></td>
                            <td><?php echo $perm->name; ?></td>
                            <td><?php echo $perm->description; ?></td>
                            <td>
                                <?php echo $form->field($model->getAssignedPermission($perm->id), 'allow')->checkbox([
                                        'name' => "assignedPermissions[".$perm->id."][allow]"
                                ])->label(false); ?>
                            	<?php /*<input type="hidden" value="0" name="p[<?php echo $perm['model']->id; ?>][allow]">
                            	<input type="checkbox" class="perm" value="1" name="p[<?php echo $perm['model']->id; ?>][allow]" <?php if(!empty($perm['allow'])):?>checked<?php endif; ?>>*/ ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <?php echo \backend\components\helpers\AdminHelper::submitButton(); ?>
                        <?php echo \backend\components\helpers\AdminHelper::cancelButton(['roles/view', 'id' => $model->assignee->id]); ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>

                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
