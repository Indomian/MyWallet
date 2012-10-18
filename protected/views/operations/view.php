<?php
/* @var $this OperationsController */
/* @var $model Operations */

$this->breadcrumbs=array(
	'Операции'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'Список операций', 'url'=>array('operations/index')),
	array('label'=>'Добавить операцию', 'url'=>array('operations/create')),
);

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'name'=>'from_account.title',
			'label'=>$model->getAttributeLabel('from_account_id'),
		),
		array(
			'name'=>'to_account.title',
			'label'=>$model->getAttributeLabel('to_account_id'),
		),
		'summ',
		'title',
		'date',
	),
));
