<?php

namespace backend\assets;

use yii\web\AssetBundle;
use MatthiasMullie\Minify;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/AdminLTE.min.css',
        'css/skins/skin-blue.min.css'
    ];
    public $js = [
        'js/adminlte.min.js',
        'js/elfinder-popup.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        //'yii\bootstrap\BootstrapAsset',
        'backend\assets\BootstrapAsset',

        'common\assets\FontAwesomeAsset',
        'backend\assets\FastclickAsset',
        'backend\assets\JquerySlimscrollAsset',
        'yii\web\YiiAsset',

        'common\assets\ElfinderAsset',
        'common\assets\MagnificPopupAsset',
    ];

    /*public function minify($type, $assets, $minPath, $force = false)
    {
        if(!is_file($minPath) || (is_file($minPath) && $force)){
            //unlink old minified file
            //@unlink($minPath);

            //create minifier
            $minifier = null;
            if($type == 'css'){
                $minifier = new Minify\CSS($minPath);
            } else if($type == 'js'){
                $minifier = new Minify\JS($minPath);
            }

            //add files
            if($minifier instanceof Minify\Minify){
                foreach($assets as $asset){
                    if(is_file($asset)){
                        $minifier->add($asset);
                    }
                }
            }

            // save minified files to disk
            $minifier->minify($minPath);
        }
    }

    public function registerAssetFiles($view)
    {
        $cssPath = 'css/vendor.min.css';
        $jsPath = 'js/vendor.min.js';
        $cssMinifier = new Minify\CSS($cssPath);
        $jsMinifier = new Minify\JS($jsPath);

        $manager = $view->getAssetManager();
        foreach ($this->js as $js) {
            if (is_array($js)) {
                $file = array_shift($js);
                $filePath = $manager->getAssetPath($this, $file);
                $jsMinifier->add($filePath);
            } else {
                if ($js !== null) {
                    $filePath = $manager->getAssetPath($this, $js);
                    $jsMinifier->add($filePath);
                }
            }
        }
        $jsMinifier->minify($jsPath);
        $this->js = [
           $jsPath
        ];

        foreach ($this->css as $css) {
            if (is_array($css)) {
                $file = array_shift($css);
                $filePath = $manager->getAssetPath($this, $file);
                $cssMinifier->add($filePath);
            } else {
                if ($css !== null) {
                    $filePath = $manager->getAssetPath($this, $css);
                    $cssMinifier->add($filePath);
                }
            }
        }
        $cssMinifier->minify($cssPath);
        $this->css = [
            $cssPath
        ];

        parent::registerAssetFiles($view);
    }*/
}
