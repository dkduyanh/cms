<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\cms\Type */

$this->title = Yii::t('cms/types', 'Create Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('cms/types', 'Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="type-create" class="row">
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
