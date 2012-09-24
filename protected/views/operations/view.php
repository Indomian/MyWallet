<?php
/* @var $this OperationsController */
/* @var $model Operations */

$this->breadcrumbs=array(
	'Operations'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Operations', 'url'=>array('index')),
	array('label'=>'Create Operations', 'url'=>array('create')),
	array('label'=>'Update Operations', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Operations', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Operations', 'url'=>array('admin')),
);
?>

<h1>View Operations #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'account_id',
		'summ',
		'title',
		'date',
	),
)); ?>
