<?php
/* @var $this OperationsController */
/* @var $model Operations */

$this->breadcrumbs=array(
	'Операции'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'Список операций', 'url'=>array('index')),
	array('label'=>'Добавить операцию', 'url'=>array('create')),
);

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'from_account_id',
		'to_account_id',
		'summ',
		'title',
		'date',
	),
));
