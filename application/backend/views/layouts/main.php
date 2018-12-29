<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

common\assets\Select2Asset::register($this);
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo Html::encode($this->title) ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!--<link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">-->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
    <![endif]-->

    <?php echo Html::csrfMetaTags() ?>
    <?php $this->head() ?>
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini <?php if(isset($_COOKIE['toggleState']) && $_COOKIE['toggleState'] == 'hide'): ?> sidebar-collapse<?php endif; ?>">
    <?php $this->beginBody() ?>
    <div class="wrapper">
        <?php echo $this->render('_header.php'); ?>
        <?php echo $this->render('_menu.php'); ?>
        <?php echo $this->render('_content.php', ['content' => $content]) ?>
        <?php echo $this->render('_footer.php'); ?>
    </div>

    <?php $this->endBody() ?>
    <!--<script src="<?php echo \yii\helpers\Url::to('@web/vendor/browser-cookies/src/browser-cookies.js'); ?>"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.sidebar-menu').tree();

            $('.sidebar-toggle').click(function(){
                Cookies.set('toggleState', $('body').hasClass('sidebar-collapse') ? 'show' : 'hide');
            });

            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>
</body>
</html>
<?php $this->endPage() ?>