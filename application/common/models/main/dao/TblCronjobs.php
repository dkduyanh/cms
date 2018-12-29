<?php

namespace common\models\main\dao;

use Yii;

/**
 * This is the model class for table "{{%cronjobs}}".
 *
 * @property string $id
 * @property string $name
 * @property string $type
 * @property string $command
 * @property string $created_date
 * @property string $creator_id
 * @property string $last_modified_date
 * @property string $last_modifier_id
 * @property string $start_date
 * @property string $end_date
 * @property string $interval
 * @property string $next_run_date
 * @property string $last_run_date
 * @property string $last_run_result
 * @property int $position
 * @property int $status
 */
class TblCronjobs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cronjobs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'command' => 'Command',
            'created_date' => 'Created Date',
            'creator_id' => 'Creator ID',
            'last_modified_date' => 'Last Modified Date',
            'last_modifier_id' => 'Last Modifier ID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'interval' => 'Interval',
            'next_run_date' => 'Next Run Date',
            'last_run_date' => 'Last Run Date',
            'last_run_result' => 'Last Run Result',
            'position' => 'Position',
            'status' => 'Status',
        ];
    }
}
