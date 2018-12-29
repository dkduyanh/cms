<?php
use yii\helpers\Html;

$this->title = 'System Information';
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'System'), 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-solid">
    <div class="box-body">
        <h2><?php echo $this->title; ?></h2>
        <table class="table table-striped table-bordered">
            <thead>
            <tr role="row">
                <th width="200px"><?php echo Yii::t('common', 'Name'); ?></th>
                <th><?php echo Yii::t('common', 'Value'); ?></th>
            </thead>
            <tbody>
            <tr role="row">
                <td>System </td>
                <td><?php echo php_uname(); ?></td>
            </tr>
            <tr role="row">
                <td>PHP Version</td>
                <td><?php echo phpversion(); ?></td>
            </tr>
            <tr role="row">
                <td>Server Software </td>
                <td><?php echo isset($_SERVER['SERVER_SOFTWARE'])?$_SERVER['SERVER_SOFTWARE']:getenv('SERVER_SOFTWARE'); ?></td>
            </tr>
            <tr role="row">
                <td>Server IP</td>
                <td><?php echo $_SERVER['SERVER_ADDR']; ?></td>
            </tr>
            <tr role="row">
                <td>Database Driver</td>
                <td><?php echo Yii::$app->db->getDriverName(); ?></td>
            </tr>
            <tr role="row">
                <td>Database charset</td>
                <td><?php echo Yii::$app->db->charset; ?></td>
            </tr>
            <tr role="row">
                <td>Default Timezone</td>
                <td><?php echo getDefaultTimeZone(); ?></td>
            </tr>
            <tr role="row">
                <td>Database Timezone</td>
                <td><?php echo getDBTimeZone(); ?></td>
            </tr>
            <tr role="row">
                <td>Server Time<br>Date('Y-m-d H:i:s')</td>
                <td><?php echo date('Y-m-d H:i:s'); ?></td>
            </tr>
            <tr role="row">
                <td>Max Execution Time</td>
                <td><?php echo ini_get('max_execution_time'); ?></td>
            </tr>
            <tr role="row">
                <td>Memory Limit</td>
                <td><?php echo ini_get('memory_limit'); ?></td>
            </tr>
            <tr role="row">
                <td>Maximum allowed size for uploaded files</td>
                <td><?php echo ini_get('upload_max_filesize'); ?></td>
            </tr>

            </tbody>
        </table>
    </div>
</div>



<?php
function getDefaultTimeZone()
{
    $timezone = date_default_timezone_get();
    $now = new DateTime();
    $offset = $now->getOffset()/3600;
    return 'UTC'.(($offset==0)?'':(($offset > 0)?'+':'-').$offset);
}

function getDBTimeZone()
{
    if(Yii::$app->db->getDriverName() == 'mysql'){
        $ret = Yii::$app->db->createCommand("select timediff(now(),convert_tz(now(),@@session.time_zone,'+00:00'));")->queryScalar();
        $rets = explode(':', $ret);
        $offset = (int)$rets[0];
        return 'UTC'.(($offset==0)?'':(($offset > 0)?'+':'-').$offset);
    }
    return null;
}
?>