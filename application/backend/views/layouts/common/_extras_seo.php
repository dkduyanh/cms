<div class="panel panel-default">
    <div class="panel-heading strong"><i class="fa fa-search"></i> SEO</div>
    <div class="panel-body">

        <?php echo $form->field($model, 'extras[seo][title]')->textInput()->label('Meta Title'); ?>
        <?php echo $form->field($model, 'extras[seo][keywords]')->textInput()->label('Meta Keywords'); ?>
        <?php echo $form->field($model, 'extras[seo][description]')->textInput()->label('Meta Description'); ?>
        <?php echo $form->field($model, 'extras[seo][robots]')->textInput()->label('Robots'); ?>
    </div>
</div>