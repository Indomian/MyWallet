<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span3">
	<div class="well" style="padding:8px 0;">
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
				'activateItems'=>true,
				'activeCssClass'=>'active',
			));
		?>
	</div>
</div><!-- sidebar -->
<div class="span9">
	<?php echo $content; ?>
</div><!-- content -->
<?php $this->endContent(); ?>