<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('common', 'Clear cache');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'System'), 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="box box-solid">
    <div class="box-body">
        <h4><?php echo $this->title; ?></h4>
        <?php $form = ActiveForm::begin([
            'id' => 'task-form',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'options' => ['class' => 'form-group item'],
                'template' => "{label}\n<div class=\"col-md-6 col-sm-6 col-xs-12\">{input}</div>\n<div>{error}</div>",
                'labelOptions' => ['class' => 'control-label col-md-3 col-sm-3 col-xs-12'],
                'inputOptions' => ['class' => 'form-control col-md-7 col-xs-12']
            ],
        ]);?>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
                <?php echo Html::submitButton(Yii::t('common', 'Clear all'), ['class' => 'btn btn-primary']) ?>
                <?php echo Html::a(Yii::t('common', 'Cancel'), '/', ['class' => 'btn btn-default']) ?>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
