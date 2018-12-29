<?php

namespace common\models;

use common\models\main\dao\TblSystemLog;
use yii\log\Logger;

class SystemLog extends TblSystemLog
{
    const   LEVEL_INFO = 1,
            LEVEL_NOTICE = 2,
            LEVEL_WARNING = 3,
            LEVEL_ERROR = 4;

    public static function write()
    {

    }
}