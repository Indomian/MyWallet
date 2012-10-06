<?php
/* @var $this AccountsController */
/* @var $model Accounts */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'accounts-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type',Accounts::getTypes()); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'summ'); ?>
		<?php echo $form->textField($model,'summ'); ?>
		<?php echo $form->error($model,'summ'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_operation'); ?>
		<?php echo $form->textField($model,'date_operation'); ?>
		<?php echo $form->error($model,'date_operation'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php echo $form->dropDownList($model,'parent_id',array_merge(array(''=>' -- '),CHtml::listData(Accounts::getMyAccountsTree(),'id','title')));?>
		<?php echo $form->error($model,'parent_id');?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->