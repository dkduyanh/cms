<?php

require __DIR__ . '/../application/common/config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require APPLICATION . '/common/config/main.php',
    require APPLICATION . '/frontend/config/main.php'
);

(new yii\web\Application($config))->run();
