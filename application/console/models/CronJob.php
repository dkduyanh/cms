<?php
namespace console\models;

class CronJob extends \common\models\main\CronJob
{
    public static function findActiveJobs()
    {
        return self::find()/*->where(['status' => CronJob::STATUS_ACTIVE])*/->orderBy('position ASC')->all();
    }

    /**
     * Marks job status is running
     * @return bool
     */
    public function markRunning()
    {
        $this->status = self::STATUS_RUNNING;
        return $this->save();
    }

    /**
     * Marks job status is in queue
     * @return bool
     */
    public function markInQueue()
    {
        $this->status = self::STATUS_QUEUED;
        return $this->save();
    }

    /**
     * Marks job status is active / completed
     * @return bool
     */
    public function markActive()
    {
        $this->status = self::STATUS_ACTIVE;
        return $this->save();
    }
}