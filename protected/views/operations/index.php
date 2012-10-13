<?php
/* @var $this OperationsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Операции',
);

$this->menu=array(
	array('label'=>'Добавить операцию', 'url'=>array('create')),
);

$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
));
