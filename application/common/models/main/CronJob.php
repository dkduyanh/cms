<?php

namespace common\models\main;

use common\models\main\dao\TblCronjobs;

class CronJob extends TblCronjobs
{
    const   STATUS_RUNNING = 3,
            STATUS_QUEUED = 2,
            STATUS_ACTIVE = 1,
            STATUS_INACTIVE = 0;

    const   TYPE_TERMINAL = 'TERMINAL',
            TYPE_FUNCTION = 'FUNCTION',
            TYPE_INLINE = 'INLINE';

    public function isRunning()
    {
        return $this->status === self::STATUS_RUNNING;
    }

    public function isQueued()
    {
        return $this->status === self::STATUS_QUEUED;
    }

    public function getNextRunDate($format = 'Y-m-d H:i:s')
    {
        $cron = \Cron\CronExpression::factory($this->interval);
        return $cron->getNextRunDate()->format($format);
    }
}