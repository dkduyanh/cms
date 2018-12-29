<div class="form-group field-menuitemform-link has-success">
    <label class="control-label" for="menuitemform-link">Type</label>
    <?php echo \yii\bootstrap\Html::dropDownList(
            'type',
            '',
            \yii\helpers\ArrayHelper::map(\backend\models\cms\Type::listAll(), 'id', 'name'),
            ['class' => 'form-control', 'id' => 'type']
    ); ?>
    <div><p class="help-block help-block-error"></p></div>
</div>



<div class="form-group field-menuitemform-link has-success">
    <label class="control-label" for="menuitemform-link">Post</label>
    <?php echo \yii\jui\AutoComplete::widget([
        'id' => 'post',
        'name' => 'post',
        'options' => [
            'class' => 'form-control'
        ],
        'clientOptions' => [
            'source' => new \yii\web\JsExpression("
                function( request, response ) {
                    $.ajax( {
                          url: '".\yii\helpers\Url::to(['posts/ajax'])."',
                          dataType: 'json',
                          data: {
                                type: $('#type').val(),
                                term: request.term
                          },
                          success: function( data ) {
                                ret = new Array();
                                for(var property in data){
                                    ret.push({'label': '['+property+'] '+data[property], 'value': property});
                                };
                                console.log(ret);
                                response( ret );
                          }
                    } );
                }"),
            'select' => new \yii\web\JsExpression('
                function(event, ui){
                    $(this).val(ui.item.label);
                    return false;
                }')
        ]
    ]); ?>
    <div><p class="help-block help-block-error"></p></div>
</div>

<?php $this->registerCss("
.ui-autocomplete {
    max-height: 200px;
    overflow-y: auto;
    /* prevent horizontal scrollbar */
    overflow-x: hidden;
    /* add padding to account for vertical scrollbar */
    padding-right: 20px;
} 
"); ?>

<script type="text/javascript">
$(document).ready(function(){
    var elPostType = $('#type');
    elPostType.change(function(){

    });
    elPostType.trigger('change');
});
</script>
