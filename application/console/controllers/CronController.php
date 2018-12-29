<?php
namespace console\controllers;

use console\models\CronJob;

class CronController extends \yii\console\Controller
{
    public function actionTest()
    {
        echo 'kakaka';
    }

    public function actionIndex()
    {
        //find all active jobs
        $jobModels = CronJob::findActiveJobs();

        //marks jobs is in queue (ready for execution) (prevents job is executed by another process until it's completed)
        foreach($jobModels as $job)
        {
            $job->markInQueue();
        }

        //execute job
        foreach($jobModels as $job)
        {
            $job->process();
        }



    }
}