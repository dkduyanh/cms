<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\main\TextSource */

$this->title = Yii::t('translation', 'Create Text Source');
$this->params['breadcrumbs'][] = ['label' => Yii::t('translation', 'Text Sources'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="text-source-create" class="row">
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
