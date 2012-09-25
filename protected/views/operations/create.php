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
?>

<h1>Добавить операцию</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>