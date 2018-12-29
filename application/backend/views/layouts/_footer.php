<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
    reserved.

    <?php echo \yii\helpers\Html::dropDownList('Skins', 'blue', [
        'blue' => 'blue (default)',
        'blue-light' => 'blue (light)',
        'black' => 'black',
        'black-light' => 'black (light)',
        'green' => 'green',
        'green-light' => 'green (light)',
        'purple' => 'purple',
        'purple-light' => 'purple (light)',
        'red' => 'red',
        'red-light' => 'red (light)',
        'yellow'  => 'yellow',
        'yellow-light' => 'yellow (light)',
    ], [
        'id' => 'adminlte-skin',
    ]); ?>
</footer>
<?php $this->registerJs("

  /**
   * List of all the available skins
   *
   * @type Array
   */
  var mySkins = [
    'skin-blue',
    'skin-black',
    'skin-red',
    'skin-yellow',
    'skin-purple',
    'skin-green',
    'skin-blue-light',
    'skin-black-light',
    'skin-red-light',
    'skin-yellow-light',
    'skin-purple-light',
    'skin-green-light'
  ];
  
  /**
   * Replaces the old skin with the new skin
   * @param String cls the new skin class
   * @returns Boolean false to prevent link's default action
   */
  function changeSkin(cls) {
    $.each(mySkins, function (i) {
      $('body').removeClass(mySkins[i])
    })

    $('body').addClass(cls)
    store('skin', cls)
    return false
  }

  /**
   * Store a new settings in the browser
   *
   * @param String name Name of the setting
   * @param String val Value of the setting
   * @returns void
   */
  function store(name, val) {
    if (typeof (Storage) !== 'undefined') {
      localStorage.setItem(name, val)
    } else {
      window.alert('Please use a modern browser to properly view this template!')
    }
  }








    $('#adminlte-skin').change(function(){
        if($('head').has('link#skin').length){
            $('head').find('link#skin').attr('href', '".\yii\helpers\Url::to('@web/css/skins/')."skin-'+$(this).val()+'.min.css');
        } else {
            $('head').append($('<link rel=\'stylesheet\' id=\'skin\' />').attr('href', '".\yii\helpers\Url::to('@web/css/skins/')."skin-'+$(this).val()+'.min.css'));
           
        }
        changeSkin('skin-'+$(this).val());
    });
", \yii\web\View::POS_END); ?>