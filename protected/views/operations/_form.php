<?php
/**
 * @var $this OperationsController
 * @var $model Operations
 * @var $form CActiveForm
 * @var CActiveForm $form
 */
CHtml::$errorCss='text-error';
$form=$this->beginWidget('CActiveForm', array('id'=>'operations-form','enableAjaxValidation'=>false));
	echo $form->errorSummary($model,null,null, array('class'=>'alert alert-error'));
	echo CHtml::openTag('div',array('class'=>'row-fluid'));
		echo CHtml::openTag('div',array('class'=>'span6'));
			//Список аккаунтов с которых можно перевести средства
			echo $form->labelEx($model,'from_account_id');
			$arAccounts=Accounts::getMyFrom();
			$arList=array();
			foreach($arAccounts as $obAccount) {
				$arList[$obAccount->id]=$obAccount->title.' ('.number_format($obAccount->summ,2,',',' ').' руб.)';
			}
			echo $form->dropDownList($model,'from_account_id',$arList,array('class'=>'span12'));
		echo CHtml::closeTag('div');
		//Список аккаунтов на которые можно перевести средства
		echo CHtml::openTag('div',array('class'=>'span6'));
			echo $form->labelEx($model,'to_account_id');
			$arAccounts=Accounts::getMyTo();
			$arList=array();
			foreach($arAccounts as $obAccount) {
				$arList[$obAccount->id]=$obAccount->title.' ('.number_format($obAccount->summ,2,',',' ').' руб.)';
			}
			echo $form->dropDownList($model,'to_account_id',$arList,array('class'=>'span12'));
		echo CHtml::closeTag('div');
	echo CHtml::closeTag('div');

	echo CHtml::openTag('div',array('class'=>'row-fluid'));
		echo CHtml::openTag('div',array('class'=>'span6'));
			echo $form->labelEx($model,'summ').$form->textField($model,'summ',array('class'=>'span12'));
		echo CHtml::closeTag('div');

		echo CHtml::openTag('div',array('class'=>'span6'));
			echo $form->labelEx($model,'title').$form->textField($model,'title',array('class'=>'span12','size'=>60,'maxlength'=>255));
		echo CHtml::closeTag('div');
	echo CHtml::closeTag('div');

	echo CHtml::openTag('div',array('class'=>'row-fluid'));
		echo CHtml::openTag('div',array('class'=>'span12'));
			echo CHtml::tag('button',array('class'=>'btn btn-primary'),'Добавить');
			echo CHtml::tag('div',array('class'=>'note pull-right'),'Поля отмеченные '.CHtml::tag('span',array('class'=>'required'),'*').' обязательны к заполнению.');
		echo CHtml::closeTag('div');
	echo CHtml::closeTag('div');
$this->endWidget();

