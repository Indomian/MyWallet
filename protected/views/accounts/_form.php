<?php
/* @var $this AccountsController */
/* @var $model Accounts */
/* @var $form CActiveForm */

$arR=array('class'=>'row-fluid');
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'accounts-form',
	'enableAjaxValidation'=>false,
));
echo $form->errorSummary($model,null,null, array('class'=>'alert alert-error'));
echo CHtml::openTag('div',$arR);
	echo CHtml::openTag('div',array('class'=>'span6'));
		echo $form->labelEx($model,'title').$form->textField($model,'title',array('class'=>'span12','maxlength'=>255));
	echo CHtml::closeTag('div');
	echo CHtml::openTag('div',array('class'=>'span6'));
		echo $form->labelEx($model,'type').$form->dropDownList($model,'type',Accounts::getTypes(),array('class'=>'span12'));
	echo CHtml::closeTag('div');
echo CHtml::closeTag('div');
echo CHtml::openTag('div',$arR);
	echo CHtml::openTag('div',array('class'=>'span6'));
		echo $form->labelEx($model,'summ').$form->textField($model,'summ',array('class'=>'span12'));
	echo CHtml::closeTag('div');
	echo CHtml::openTag('div',array('class'=>'span6'));
		echo $form->labelEx($model,'parent_id').$form->dropDownList($model,'parent_id',array_merge(array(''=>' -- '),CHtml::listData(Accounts::getMyAccountsTree(),'id','title')),array('class'=>'span12'));
	echo CHtml::closeTag('div');
echo CHtml::closeTag('div');
echo CHtml::openTag('div',$arR);
	echo CHtml::openTag('div',array('class'=>'span6'));
		echo CHtml::tag('button',array('class'=>'btn btn-primary'),$model->isNewRecord ? 'Создать' : 'Сохранить');
	echo CHtml::closeTag('div');
echo CHtml::closeTag('div');
$this->endWidget();