<?php
/* @var $this OperationsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Операции',
);

$this->menu=array(
	array('label'=>'Список операций', 'url'=>array('operations/index')),
	array('label'=>'Добавить операцию', 'url'=>array('operations/create')),
	array('label'=>'Отчёт за период','url'=>array('operations/report'))
);

$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'itemsCssClass'=>'table',
	'template'=>'{items}{pager}',
	'htmlOptions'=>array(
		'class'=>'',
	),
	'columns'=>array(
		array(
			'header'=>$dataProvider->model->getAttributeLabel('from_account_id'),
			'name'=>'from_account.title',
		),
		array(
			'header'=>$dataProvider->model->getAttributeLabel('to_account_id'),
			'name'=>'to_account.title',
		),
		'summ',
		array(            // display 'create_time' using an expression
			'name'=>'date',
			'value'=>'date("d.m.Y H:i:s", strtotime($data->date))',
		),
		'title'
	)
));
