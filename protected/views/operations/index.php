<?php
/* @var $this OperationsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Operations',
);

$this->menu=array(
	array('label'=>'Добавить операцию', 'url'=>array('create')),
);
?>

<h1>Операции</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
