<?php
/**
 * @var OperationsController $this
 * @var CommonReport $model
 * @var CArrayDataProvider $list
 * @var CActiveForm $form
 */

$this->breadcrumbs=array(
	'Операции'=>array('index'),
	'Отчёт за период'
);

$this->menu=array(
	array('label'=>'Список операций', 'url'=>array('operations/index')),
	array('label'=>'Добавить операцию', 'url'=>array('operations/create')),
	array('label'=>'Отчёт за период','url'=>array('operations/report'))
);

$arR=array('class'=>'row-fluid');
echo CHtml::tag('div',$arR,CHtml::tag('legend',array('class'=>'span12'),'Укажите диапазон дат за который вас интересует отчёт'));
$form=$this->beginWidget('CActiveForm', array('id'=>'filter-form','htmlOptions'=>array('class'=>'form-inline')));
echo $form->errorSummary($model,null,null, array('class'=>'alert alert-error'));
echo CHtml::openTag('div',$arR);
echo CHtml::tag('div',array('class'=>'span1'),$form->labelEx($model,'date_from'));
echo CHtml::tag('div',array('class'=>'span3'),$form->dateField($model,'date_from'));
echo CHtml::tag('div',array('class'=>'span1'),$form->labelEx($model,'date_to'));
echo CHtml::tag('div',array('class'=>'span3'),$form->dateField($model,'date_to'));
echo CHtml::openTag('div',array('class'=>'span4'));
echo CHtml::tag('button',array('class'=>'btn btn-primary'),'Указать');
echo CHtml::closeTag('div');
echo CHtml::closeTag('div');
$this->endWidget();

if($list) {
	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$list,
		'itemsCssClass'=>'table',
		'template'=>'{items}{pager}',
		'htmlOptions'=>array(
			'class'=>'',
		),
		'columns'=>array(
			'title'=>array(
				'header'=>'Расходный счёт',
				'name'=>'title'
			),
			'summ'=>array(
				'header'=>'Сумма',
				'name'=>'summ',
			),
			'count'=>array(
				'header'=>'Кол-во операций',
				'name'=>'count',
			),
		)
	));
}
