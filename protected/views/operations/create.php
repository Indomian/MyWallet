<?php
/* @var $this OperationsController */
/* @var $model Operations */

$this->breadcrumbs=array(
	'Операции'=>array('index'),
	'Добавление операции',
);

$this->menu=array(
	array('label'=>'Список операций', 'url'=>array('operations/index')),
	array('label'=>'Добавить операцию', 'url'=>array('operations/create')),
);

echo $this->renderPartial('_form', array('model'=>$model));