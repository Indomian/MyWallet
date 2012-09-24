<?php
/* @var $this OperationsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Operations',
);

$this->menu=array(
	array('label'=>'Create Operations', 'url'=>array('create')),
	array('label'=>'Manage Operations', 'url'=>array('admin')),
);
?>

<h1>Operations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
