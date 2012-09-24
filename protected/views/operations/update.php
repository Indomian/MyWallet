<?php
/* @var $this OperationsController */
/* @var $model Operations */

$this->breadcrumbs=array(
	'Operations'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Operations', 'url'=>array('index')),
	array('label'=>'Create Operations', 'url'=>array('create')),
	array('label'=>'View Operations', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Operations', 'url'=>array('admin')),
);
?>

<h1>Update Operations <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>