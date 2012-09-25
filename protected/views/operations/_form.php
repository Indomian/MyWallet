<?php
/* @var $this OperationsController */
/* @var $model Operations */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'operations-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'from_account_id'); ?>
		<?php echo $form->dropDownList($model,'from_account_id',CHtml::listData(Accounts::getMyFrom(), 'id', 'title')); ?>
		<?php echo $form->error($model,'from_account_id'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'to_account_id'); ?>
		<?php echo $form->dropDownList($model,'to_account_id',CHtml::listData(Accounts::getMyTo(), 'id', 'title')); ?>
		<?php echo $form->error($model,'to_account_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'summ'); ?>
		<?php echo $form->textField($model,'summ'); ?>
		<?php echo $form->error($model,'summ'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->