<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Авторизация';
$this->breadcrumbs=array(
	'Авторизация',
);
CHtml::$errorCss='text-error';
$form=$this->beginWidget('CActiveForm', array('id'=>'login-form','enableClientValidation'=>true,'clientOptions'=>array('validateOnSubmit'=>true,)));
$arR=array('class'=>'row-fluid');
echo CHtml::openTag('div',$arR);
	echo CHtml::tag('legend',array('class'=>'span12'),'Пожалуйста, укажите данные которые вы использовали при регистрации:');
echo CHtml::closeTag('div');
if($model->hasErrors()) {
	echo CHtml::tag('div',$arR,CHtml::tag('div',array('class'=>'span12'),$form->errorSummary($model,null,null, array('class'=>'alert alert-error'))));
}
echo CHtml::openTag('div',$arR);
	echo CHtml::openTag('div',array('class'=>'span6'));
		echo $form->labelEx($model,'username',array('class'=>'span12'));
		echo $form->textField($model,'username',array('class'=>'span12'));
	echo CHtml::closeTag('div');
	echo CHtml::openTag('div',array('class'=>'span6'));
		echo $form->labelEx($model,'password',array('class'=>'span12'));
		echo $form->passwordField($model,'password',array('class'=>'span12'));
	echo CHtml::closeTag('div');
echo CHtml::closeTag('div');
echo CHtml::openTag('div',$arR);
	echo CHtml::tag('div',array('class'=>'span6'),CHtml::tag('label',array(),$form->checkBox($model,'rememberMe').' '.$model->getAttributeLabel('rememberMe')));
	echo CHtml::tag('div',array('class'=>'span6'),CHtml::tag('button',array('class'=>'btn btn-primary'),'Войти'));
echo CHtml::closeTag('div');
echo CHtml::openTag('div',$arR);
	echo CHtml::tag('div',array('class'=>'span12'),'Поля отмеченные '.CHtml::tag('span',array('class'=>'required'),'*').' обязательны к заполнению.');
	$this->endWidget();
echo CHtml::closeTag('div');
