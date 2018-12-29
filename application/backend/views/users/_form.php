<?php

use yii\helpers\Html;
use backend\components\widgets\ActiveForm;
use common\library\Utils;
use backend\models\main\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div id="user-form">
    <?php $form = ActiveForm::begin(); ?>

	<div class="panel panel-default">
         <div class="panel-heading strong">Login Info.</div>
         <div class="panel-body">
			<?php echo $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
		    <?php echo $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
		    <?php echo $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
		    <?php echo $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
		</div>
	</div>       
	
	<div class="panel panel-default">
         <div class="panel-heading strong">Basic Info.</div>
         <div class="panel-body">
    		<?php echo $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
         	<?php echo $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
		    <?php echo $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
		    <?php echo $form->field($model, 'displayname')->textInput(['maxlength' => true]) ?>
		    <?php echo $form->field($model, 'gender')->radioList(User::genderLabels()) ?>
		    <?php echo $form->field($model, 'birthdate')->textInput() ?>
		    <?php echo $form->field($model, 'birthplace')->textInput() ?>
		    <?php echo $form->field($model, 'image')->fileInput(['maxlength' => true]) ?>

            <?php if($arrUserTitles = User::listTitles() && !empty($arrUserTitles) ): ?>
            <?php echo $form->field($model, 'title')->dropDownList($arrUserTitles) ?>
            <?php endif; ?>

		    <?php echo $form->field($model, 'about_me')->textarea(['rows' => 5]) ?>
		    <?php echo $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
         </div>
	</div>


    <div class="panel panel-default">
         <div class="panel-heading strong">Settings</div>
         <div class="panel-body">
         	<?php echo $form->field($model, 'timezone')->dropDownList(Utils::getTimezones()); ?>
		    <?php echo $form->field($model, 'language')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\main\Language::listAll(), 'code', 'name')); ?>
		    <?php echo $form->field($model, 'verified')->checkbox(['class' => 'js-switch'], false); ?>
		    <?php echo $form->field($model, 'status')->dropDownList(User::statusLabels()); ?>
         </div>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <?php echo \backend\components\helpers\AdminHelper::submitButton(); ?>
            <?php if($model->isNewRecord): ?>
                <?php echo \backend\components\helpers\AdminHelper::cancelButton(['index']); ?>
            <?php else: ?>
                <?php echo \backend\components\helpers\AdminHelper::cancelButton(['view', 'id' => $model->id]); ?>
            <?php endif; ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJs("
            $(function () {
                $('#".Html::getInputId($model, 'birthdate')."').datepicker();
            });	
");?>
