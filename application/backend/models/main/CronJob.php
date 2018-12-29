<?php

namespace backend\models\main;


use Cron\CronExpression;

class CronJob extends \common\models\main\CronJob
{
    public static function statusLabels()
    {
        return [
            self::STATUS_RUNNING => 'RUNNING',
            self::STATUS_QUEUED => 'QUEUED',
            self::STATUS_ACTIVE => 'ACTIVE',
            self::STATUS_INACTIVE => 'INACTIVE'
        ];
    }

    public static function typeLabels()
    {
        return [
            self::TYPE_TERMINAL => 'TERMINAL',
            self::TYPE_FUNCTION => 'FUNCTION',
            self::TYPE_INLINE => 'INLINE',
        ];
    }

    public static function predefinedIntervalLabels()
    {
        return [
            '*/5 * * * *' => 'Every 5 minutes',
            '*/10 * * * *' => 'Every 10 minutes',
            '*/15 * * * *' => 'Every 15 minutes',
            '0 * * * *' => '@hourly',
            '0 0 * * *' => '@daily',
            '0 0 * * 0' => '@weekly',
            '0 0 1 * *' => '@monthly',
            '0 0 1 1 *' => '@annually',
            '0 0 1 1 *' => '@yearly',
        ];
    }

    public function updateNextRunDate($from = null)
    {
        $this->next_run_date = (new CronExpression())->getNextRunDate($from)->format('Y-m-d H:i:s');
        return $this->save();
    }

    public function getStatusLabel()
    {
        return @self::statusLabels()[$this->status];
    }
}