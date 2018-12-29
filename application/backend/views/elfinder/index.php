<?php
$this->title = "Media";

\common\assets\ElfinderAsset::register($this);
?>
<style type="text/css">
    .elfinder-contextmenu{
        z-index:9999;
    }
</style>

<div id="elfinder">abcd</div>

<?php $this->registerJs("    
    $(document).ready(function() {
        var tokenKey = '".Yii::$app->request->csrfParam."';
        var options = {			
        	width: '100%',
        	height: '600px',
            cssAutoLoad : false,                                // Disable CSS auto loading
            baseUrl : './',                                     // Base URL to css/*, js/*
            url : '".\yii\helpers\Url::to(['process'], true)."' // connector URL (REQUIRED)
            // , lang: 'ru',                                     // language (OPTIONAL)
            ,handlers : {
                open : function(e, fm) {
                    if (e.data && e.data[tokenKey]) {
                        fm.customData[tokenKey] = e.data[tokenKey];
                    }
                }
            }
        }
        $('#elfinder').elfinder(options);
    });
"); ?>
