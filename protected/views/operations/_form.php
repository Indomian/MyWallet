<?php
/**
 * @var $this OperationsController
 * @var $model Operations
 * @var $form CActiveForm
 * @var CActiveForm $form
 */
$form=$this->beginWidget('CActiveForm', array('id'=>'operations-form','enableAjaxValidation'=>false));
	echo CHtml::openTag('div',array('class'=>'row-fluid'));
		echo CHtml::openTag('div',array('class'=>'span6'));
			//Список аккаунтов с которых можно перевести средства
			echo $form->labelEx($model,'from_account_id');
			$arAccounts=Accounts::getMyFrom();
			$arList=array();
			foreach($arAccounts as $obAccount) {
				$arList[$obAccount->id]=$obAccount->title.' ('.number_format($obAccount->summ,2,',',' ').' руб.)';
			}
			echo $form->dropDownList($model,'from_account_id',$arList).$form->error($model,'from_account_id');
		echo CHtml::closeTag('div');
		//Список аккаунтов на которые можно перевести средства
		echo CHtml::openTag('div',array('class'=>'span6'));
			echo $form->labelEx($model,'to_account_id');
			$arAccounts=Accounts::getMyTo();
			$arList=array();
			foreach($arAccounts as $obAccount) {
				$arList[$obAccount->id]=$obAccount->title.' ('.number_format($obAccount->summ,2,',',' ').' руб.)';
			}
			echo $form->dropDownList($model,'to_account_id',$arList).$form->error($model,'to_account_id');
		echo CHtml::closeTag('div');
	echo CHtml::closeTag('div');

	echo CHtml::openTag('div',array('class'=>'row-fluid'));
		echo CHtml::openTag('div',array('class'=>'span6'));
			echo $form->labelEx($model,'summ').$form->textField($model,'summ').$form->error($model,'summ');
		echo CHtml::closeTag('div');

		echo CHtml::openTag('div',array('class'=>'span6'));
			echo $form->labelEx($model,'title').$form->textField($model,'title',array('size'=>60,'maxlength'=>255));
			echo $form->error($model,'title');
		echo CHtml::closeTag('div');
	echo CHtml::closeTag('div');

	echo CHtml::openTag('div',array('class'=>'row-fluid'));
		echo CHtml::openTag('div',array('class'=>'span4'));
			echo CHtml::submitButton('Добавить');
		echo CHtml::closeTag('div');
		echo CHtml::openTag('div',array('class'=>'span8 pull-right'));
			echo CHtml::tag('p',array('class'=>'note'),'Поля отмеченные '.CHtml::tag('span',array('class'=>'required'),'*').' обязательны к заполнению.');
		echo CHtml::closeTag('div');
	echo CHtml::closeTag('div');
$this->endWidget();

