<?php
namespace backend\controllers;

use backend\models\ChangePasswordForm;
use backend\models\main\User;
use console\models\CronJob;
use Yii;
use backend\models\LoginForm;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionTest()
    {
        //TODO :: REQUIRE SECRET KEY FOR PERFORMING

        //TODO :: DON'T ALLOW TO RUN IN MAINTENANCE MODE
        echo 'Now: '.date('Y-m-d H:i:s');
        $cron = \Cron\CronExpression::factory('*/2 * * * *');
        v($cron->isDue());
        echo $cron->getNextRunDate()->format('Y-m-d H:i:s');
        echo '<br>';
        echo $cron->getPreviousRunDate()->format('Y-m-d H:i:s');

        die;

        //TODO :: ONLY RUN IN CLI MODE
        $sapi_type = php_sapi_name();
        if (substr($sapi_type, 0, 3) != 'cli') {
            //die("CronJob is CLI only.");
        }

        //find all active jobs
        $jobModels = CronJob::findActiveJobs();

        //Stop processing if no job found!
        if(count($jobModels) == 0){
            return 'No scheduled commands are ready to run.';
        }

        //enqueue the jobs -- (marks jobs is in queue to prevent being executed by another process until it's completed)
        foreach($jobModels as $job)
        {
            $job->markInQueue();
        }

        //execute jobs
        foreach($jobModels as $job)
        {
            $job->markRunning();

            v($job->getNextRunDate());

            if($job->type == CronJob::TYPE_INLINE){
                //eval($job->command);
            }
            if($job->type == CronJob::TYPE_TERMINAL){
                $cmd = PHP_BINARY . ' ' . $job->command;
                if(function_exists('shell_exec')){
                    shell_exec($cmd);
                }
            }
            if($job->type == CronJob::TYPE_FUNCTION){
                $cliScriptName = 'yii';
                $cmd = PHP_BINARY . ' ' . $cliScriptName . ' ' . $job->command;
                if(function_exists('shell_exec')){
                    shell_exec($cmd);
                }
            }

            $job->markActive();
        }
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = false;
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Change password of current logged-in user
     * @return string
     */
    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();

        $user = User::find()->where(['id' => Yii::$app->user->id])->one();
        if($user === null){
            throw new NotFoundHttpException('User is null');
        }

        $model->setUser($user);
        if($model->load(Yii::$app->request->post()) && $model->update())
        {
            $this->showFlashSuccessMessage('Your password has been changed successfully!');
            Yii::$app->user->logout();
            return $this->refresh();
        }
        $this->showFlashModelErrors($model);

        return $this->render('change-password', [
            'model' => $model
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionSendTestEmail()
    {
        if(Yii::$app->request->isPost){
            $email = Yii::$app->request->post('email');
            if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
                \Yii::$app->session->setFlash('danger', 'Please input a valid email!');
            } else{
                $isSent = Yii::$app->mailer->compose()
                    ->setFrom(MAILER_DEFAULT_SENDER_EMAIL)
                    ->setTo($email)
                    ->setSubject("Email sent from ".Yii::$app->id)
                    ->setTextBody("This email was sent in order to test the outgoing mail server information provided in the ".Yii::$app->id.".  \nA successful receipt of this email indicates that the outgoing mail server information provided is valid.")
                    ->send();
                if($isSent){
                    \Yii::$app->session->setFlash('success', 'An email was sent to \''.$email.'\'');
                } else{
                    \Yii::$app->session->setFlash('danger', 'Email was not sent!');
                }
            }
            return $this->refresh();
        }
        return $this->render('send-test-email');
    }

    public function actionInfo()
    {
        return $this->render('info', [
            //'dbInfo' => SystemInfo::getDbInfo(),
            //'phpInfo' => SystemInfo::getPhpInfo()
        ]);
    }

    public function actionClearCache()
    {
        $disabled = true;
        if($disabled)
        {
            $this->showFlashErrorMessage('For security purposes, the feature you have requested is not available on the demo site.');

        }
        if(Yii::$app->request->isPost){
            Yii::$app->cache->flush();

            foreach(glob(Yii::$app->cache->cachePath.'/*') as $item)
            {
                FileHelper::removeDirectory($item);
            }
            foreach(glob(Yii::$app->runtimePath.'/min/*') as $item)
            {
                FileHelper::removeDirectory($item);
            }
            /*foreach(glob(Yii::$app->assetManager->basePath.'/*') as $item)
            {
                FileHelper::removeDirectory($item);
            }*/

            Yii::$app->session->setFlash('success', Yii::t('common', 'Updated successfully!'));
            return $this->refresh();
        }
        return $this->render('clear-cache');
    }
}
