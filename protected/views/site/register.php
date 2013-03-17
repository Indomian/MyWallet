<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name.' - Регистрация';
$this->breadcrumbs=array(
    'Регистрация',
);

$arR=array('class'=>'row-fluid');
echo CHtml::tag('div',$arR,CHtml::tag('legend',array('class'=>'span12'),'Регистрация на сайте'));
echo CHtml::tag('div',$arR,CHtml::tag('p',array('class'=>'span12'),'Укажите ваш логин и пароль. Указанные данные будут
необходимы для повторной авторизации на сайте.'));
$form=$this->beginWidget('CActiveForm', array('id'=>'users-form','enableAjaxValidation'=>false));
if($model->hasErrors()) {
	echo CHtml::tag('div',$arR,CHtml::tag('div',array('class'=>'span12'),$form->errorSummary($model,null,null, array('class'=>'alert alert-error'))));
}
echo CHtml::openTag('div',$arR);
	echo CHtml::openTag('div',array('class'=>'span6'));
		echo $form->labelEx($model,'login',array('class'=>'span12','maxlength'=>255));
		echo $form->textField($model,'login',array('class'=>'span12'));
	echo CHtml::closeTag('div');
	echo CHtml::openTag('div',array('class'=>'span6'));
		echo $form->labelEx($model,'password',array('class'=>'span12'));
		echo $form->passwordField($model,'password',array('class'=>'span12'));
	echo CHtml::closeTag('div');
echo CHtml::closeTag('div');
echo CHtml::openTag('div',$arR);
echo CHtml::tag('div',array('class'=>'span6'),CHtml::tag('button',array('class'=>'btn btn-primary'),'Зарегистрироваться'));
echo CHtml::tag('div',array('class'=>'span6'),'Поля отмеченные <span class="required">*</span> обязательны к заполнению.');
$this->endWidget();
