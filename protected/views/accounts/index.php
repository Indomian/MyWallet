<?php
/* @var $this AccountsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Счета',
);

$this->menu=array(
	array('label'=>'Добавить счёт', 'url'=>array('create')),
	array('label'=>'Управлять счетами', 'url'=>array('manage')),
);
?>

<h1>Счета</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
