<?php
/* @var $this OperationsController */
/* @var $model Operations */

$this->breadcrumbs=array(
	'Operations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Operations', 'url'=>array('index')),
	array('label'=>'Manage Operations', 'url'=>array('admin')),
);
?>

<h1>Create Operations</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>