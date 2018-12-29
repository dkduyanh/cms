<?php

namespace console\controllers;


use backend\assets\AppAsset;
use common\models\main\User;
use yii\console\Controller;
use MatthiasMullie\Minify\Minify;
use yii\web\AssetManager;

class AdminController extends Controller
{
    public function actionResetUserPassword($login)
    {
        $model = User::findOne($login);
        $model->scenario = User::SCENARIO_RESET_PASSWORD;
        $model->password = $model->confirm_password = \Yii::$app->security->generateRandomString(6);
        if($model->validate()){
            if(!$model->save()){
                $this->stdout("Error: Can not change password \n");
            } else {
                $this->stdout("Password has changed successfully! \n");
                $this->stdout('New password is '.$model->password."\n");
            }
        }
        $this->stdout('Done');
    }

    public function actionClearCache()
    {

    }
}