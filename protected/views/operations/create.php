<?php
/* @var $this OperationsController */
/* @var $model Operations */

$this->breadcrumbs=array(
	'Операции'=>array('index'),
	'Добавление операции',
);

$this->menu=array(
	array('label'=>'Список операций', 'url'=>array('index')),
);

echo $this->renderPartial('_form', array('model'=>$model));