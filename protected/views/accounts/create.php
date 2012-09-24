<?php
/* @var $this AccountsController */
/* @var $model Accounts */

$this->breadcrumbs=array(
	'Счета'=>array('index'),
	'Создание счета',
);

$this->menu=array(
	array('label'=>'Список счетов', 'url'=>array('index')),
	array('label'=>'Управлять счетами', 'url'=>array('manager')),
);
?>

<h1>Создание счёта</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>