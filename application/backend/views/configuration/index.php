<?php

use yii\helpers\Url;

$this->title = Yii::t('configuration', 'Configurations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="configuration-index" class="box">
    <div class="box-body">
        <div class="col-md-12">
            <h4>Components</h4>
            <ul class="setting-icons list-unstyled">
                <li class="col-md-2">
                    <a href="<?php echo Url::to(['email-templates/index']); ?>"><i class="fa fa-envelope"></i> Email Templates </a>
                </li>
                <li class="col-md-2">
                    <a href="<?php echo Url::to(['menu/index']); ?>"><i class="fa fa-sitemap"></i> Menu</a>
                </li>
                <li class="col-md-2">
                    <a href="<?php echo Url::to(['languages/index']); ?>"><i class="fa fa-language"></i> Languages </a>
                </li>
                <li class="col-md-2">
                    <a href="<?php echo Url::to(['cronjobs/index']); ?>"><i class="fa fa-clock-o"></i> Schedules </a>
                </li>
                <li class="col-md-2">
                    <a href="<?php echo Url::to(['subscribers/index']); ?>"><i class="fa fa-rocket"></i> Subscription </a>
                </li>
            </ul>
        </div>
        <hr>
        <div class="col-md-12">
            <h4>Settings</h4>
            <ul class="setting-icons list-unstyled">
                <li class="col-md-2">
                    <a href="<?php echo Url::to(['configuration/general']); ?>"><i class="fa fa-cog"></i> General </a>
                </li>
                <li class="col-md-2">
                    <a href="<?php echo Url::to(['configuration/cms']); ?>"><i class="fa fa-edit"></i> Content </a>
                </li>
                <li class="col-md-2">
                    <a href="<?php echo Url::to(['configuration/contact-info']); ?>"><i class="fa fa-address-book"></i> Contact Info </a>
                </li>
                <li class="col-md-2">
                    <a href="<?php echo Url::to(['configuration/user']); ?>"><i class="fa fa-users"></i> Accounts </a>
                </li>
            </ul>
        </div>
        <hr>
        <div class="col-md-12">
            <h4>System</h4>
            <ul class="setting-icons list-unstyled">
                <li class="col-md-2">
                    <a href="<?php echo Url::to(['system-log/index']); ?>"><i class="fa fa-file"></i> System Logs </a>
                </li>
                <li class="col-md-2">
                    <a href="<?php echo Url::to(['site/clear-cache']); ?>"><i class="fa fa-trash"></i> Clear cache </a>
                </li>
                <li class="col-md-2">
                    <a href="<?php echo Url::to(['site/change-password']); ?>"><i class="fa fa-key"></i> Change Password </a>
                </li>
                <li class="col-md-2">
                    <a href="<?php echo Url::to(['site/info']); ?>"><i class="fa fa-info"></i> System Information </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<style type="text/css">
    #configuration-index h4{
        padding:25px 0;
        font-weight: bold;
        line-height: 1.2;
    }
    .setting-icons{

    }
    .setting-icons li{
        text-align: center;
    }
    .setting-icons .fa{
        font-size: 40px;
        display: block;
        text-align: center;
        padding:15px;
    }

</style>