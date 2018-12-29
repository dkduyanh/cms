<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use \backend\components\widgets\GridView;
?>

<p>
	<?php echo \yii\helpers\Html::a(Yii::t('cms/fields', 'Add Field'), ['update-field', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
</p>
<?php Pjax::begin(); ?>
<?php echo GridView::widget([
	'dataProvider' => $dataProvider,
	'columns' => [
		['class' => 'yii\grid\SerialColumn'],

		//'id',
		[
			'attribute' => 'name',
			'format' => 'raw',
			'value' => function ($model, $key, $index, $column) {
				return Html::a($model->name, ['fields/view', 'id' => $model->id], ['data-pjax' => "0"]);
			},
		],
		'code',
		'description',
		// 'group',
		// 'position',
		// 'settings:ntext',

		[
			'class' => 'yii\grid\ActionColumn',
			'urlCreator' => function ($action, $model, $key, $index) use ($model) {
				if($action == 'view')
				{
					return ['fields/view', 'id' => $model->id];
				}
				else if($action == 'update')
				{
					return ['update-field', 'id' => $model->id, 'field' => $model->id];
				} else if($action == 'delete')
				{
					return ['delete-field', 'id' => $model->id, 'field' => $model->id];
				}
			},
			'headerOptions' => ['width' => '75px'],
		],
	],
]); ?>
<?php Pjax::end(); ?>