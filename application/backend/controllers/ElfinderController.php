<?php

namespace backend\controllers;

use backend\models\cms\Media;
use Yii;

class ElfinderController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return parent::behaviors();
    }

    public function actionIndex()
    {
        $isAjax = Yii::$app->request->isAjax;
        if($isAjax){
            $this->layout = false;
        }
        return $this->render('index', array(
            'isAjax' => $isAjax
        ));
    }

    public function actionProcess()
    {
        require_once  dirname(__DIR__).'/models/elFinderVolumeCmsMedia.php';
        $opts = array(
            //pass csrf tokey. Read more at https://github.com/Studio-42/elFinder/issues/1328
            'bind' => array(
                '*' => function($cmd, &$result, $args, $elfinder){
                    $result[Yii::$app->request->csrfParam] = Yii::$app->request->csrfToken;
                }
            ),

            // 'debug' => true,
            'roots' => array(
                /*  array(
                    'driver'        => 'LocalFileSystem',           // driver for accessing file system (REQUIRED)
                    'path'          => UPLOADS_DIR.'/cms/',                 // path to files (REQUIRED)
                    'URL'           => UPLOADS_URL.'/cms/', 				// URL to files (REQUIRED)
                    'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
                    'uploadAllow'   => array('image', 'text/plain'),// Mimetype `image` and `text/plain` allowed to upload
                    'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
                    'accessControl' => 'access',                     // disable and hide dot starting files (OPTIONAL)
                    'encoding'    => 'CP1258'
                    //'disabled' => array('copy', 'cut', 'paste', 'rename')
                ), */

                array(
                    'driver'        => 'CmsMedia',
                    //'URL'           => NewMedia::UPLOADS_URL, 				// URL to files (REQUIRED)
                    'tmbPath'       => Media::UPLOADS_DIR.'/.tmb',
                    'tmbURL'		=> Media::UPLOADS_URL.'/.tmb',
                    'tmpPath'       => Media::TEMP_DIR.'/.tmp',
                    'path'			=> '1',
                ),
            ),
        );


        /*$opts = array(
            // 'debug' => true,
            'roots' => array(
                // Items volume
                array(
                    'driver'        => 'LocalFileSystem',           // driver for accessing file system (REQUIRED)
                    'path'          => '../files/',                 // path to files (REQUIRED)
                    'URL'           => dirname($_SERVER['PHP_SELF']) . '/../files/', // URL to files (REQUIRED)
                    'trashHash'     => 't1_Lw',                     // elFinder's hash of trash folder
                    'winHashFix'    => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
                    'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
                    'uploadAllow'   => array('image', 'text/plain'),// Mimetype `image` and `text/plain` allowed to upload
                    'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
                    'accessControl' => 'access'                     // disable and hide dot starting files (OPTIONAL)
                ),
                // Trash volume
                array(
                    'id'            => '1',
                    'driver'        => 'Trash',
                    'path'          => '../files/.trash/',
                    'tmbURL'        => dirname($_SERVER['PHP_SELF']) . '/../files/.trash/.tmb/',
                    'winHashFix'    => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
                    'uploadDeny'    => array('all'),                // Recomend the same settings as the original volume that uses the trash
                    'uploadAllow'   => array('image', 'text/plain'),// Same as above
                    'uploadOrder'   => array('deny', 'allow'),      // Same as above
                    'accessControl' => 'access',                    // Same as above
                )
            )
        );*/
        if(Yii::$app->request->isPost){
            //v($_POST); o($_FILES);
        }
        // run elFinder
        $connector = new \elFinderConnector(new \elFinder($opts));
        $connector->run();
    }
}