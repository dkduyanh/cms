<?php

namespace backend\components\widgets;


use backend\assets\SwitcheryAsset;

class ActiveForm extends \yii\bootstrap\ActiveForm
{
    public $options = ['class' => 'form-horizontal'];
    public $fieldConfig = [
        'options' => ['class' => 'form-group'],
        'template' => "{label}\n<div class=\"col-sm-6 col-xs-12\">{input}{hint}</div>\n<div>{error}</div>",
        'labelOptions' => ['class' => 'control-label col-sm-3 col-xs-12'],
        'inputOptions' => ['class' => 'form-control col-sm-7 col-xs-12'],
    ];

    public function run()
    {
        $view = $this->getView();
        SwitcheryAsset::register($view);

        $view->registerJs("
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            elems.forEach(function(html) {
                var switchery = new Switchery(html);
            });
        ");

        parent::run();
    }
}