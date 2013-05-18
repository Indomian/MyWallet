<?php
/* @var $this AccountsController */
/* @var $model Accounts */

$this->breadcrumbs=array(
	'Счета'=>array('index'),
	'Управлять',
);

$this->menu=array(
	array('label'=>'Список счетов', 'url'=>array('index')),
	array('label'=>'Создать счёт', 'url'=>array('create')),
);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'accounts-grid',
	'dataProvider'=>$model->search(),
	'itemsCssClass'=>'table',
	'columns'=>array(
		'title',
		'type',
		'summ',
		'date_operation',
		array(
			'class'=>'CButtonColumn',
		),
	),
));
