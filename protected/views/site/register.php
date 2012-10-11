<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
    'Регистрация',
);

$this->menu=array(
    array('label'=>'List Users', 'url'=>array('index')),
    array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>

<h1>Регистрация на сайте</h1>

<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array('id'=>'users-form','enableAjaxValidation'=>false)); ?>
        <p class="note">Поля отмеченные <span class="required">*</span> обязательны к заполнению.</p>
        <?php echo $form->errorSummary($model); ?>
        <div class="row">
            <?php echo $form->labelEx($model,'login'); ?>
            <?php echo $form->textField($model,'login',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'login'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'password'); ?>
            <?php echo $form->passwordField($model,'password',array('size'=>32,'maxlength'=>32)); ?>
            <?php echo $form->error($model,'password'); ?>
        </div>
        <div class="row buttons">
            <?php echo CHtml::submitButton('Зарегистрироваться'); ?>
        </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->