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
	array('label'=>'Отчёт за период','url'=>array('operations/report'))
);

echo $this->renderPartial('_form', array('model'=>$model));