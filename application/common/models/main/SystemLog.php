<?php

namespace common\models\main;

use common\models\main\dao\TblSystemLog;

class SystemLog extends TblSystemLog
{
    const   LEVEL_ERROR = E_ERROR,
            LEVEL_WARNING = E_WARNING,
            LEVEL_INFO = 4;

    public function getLevelLabel()
    {
        return @self::levelLabels()[$this->level];
    }

    public static function levelLabels($level = null){
        return [
            self::LEVEL_ERROR => 'error',
            self::LEVEL_WARNING => 'warning',
            self::LEVEL_INFO => 'info',
        ];
    }

}