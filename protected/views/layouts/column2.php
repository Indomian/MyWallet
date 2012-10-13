<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row-fluid">
	<div class="span3">
		<?php
			if(is_array($this->menu)) {
				$this->menu=array_merge(array(
					array('label'=>'Операции','itemOptions'=>array('class'=>'nav-header')))
					,
					$this->menu
				);
			}
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'nav nav-list'),
			));
		?>
	</div><!-- sidebar -->
	<div class="span9">
		<?php echo $content; ?>
	</div><!-- content -->

</div>
<?php $this->endContent(); ?>