<div class="panel panel-default">
    <div class="panel-heading strong"><i class="fa fa-paint-brush"></i> Appearance</div>
    <div class="panel-body">

        <?php echo $form->field($model, 'extras[appearance][image]')->textInput()->label('Image'); ?>
        <?php echo $form->field($model, 'extras[appearance][image_alt]')->textInput()->label('Image Alt'); ?>
        <?php echo $form->field($model, 'extras[appearance][class]')->textInput()->label('Class'); ?>
        <?php echo $form->field($model, 'extras[appearance][style]')->textInput()->label('CSS'); ?>
    </div>
</div>