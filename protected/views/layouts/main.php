<?php /* @var $this Controller */ ?>
<!DOCTYPE html >
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="ru" />
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		<link href="/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="/css/bootstrap-responsive.css" rel="stylesheet">
	</head>
	<body>
		<div class="container">
			<div class="row-fluid">
				<div class="navbar navbar-static-top">
					<div class="navbar-inner">
						<a class="brand" href="/"><?php echo CHtml::encode(Yii::app()->name); ?></a>
						<?php $this->widget('zii.widgets.CMenu',array(
							'htmlOptions'=>array(
								'class'=>'nav'
							),
							'activateItems'=>'true',
							'activeCssClass'=>'active',
							'items'=>array(
								array('label'=>'Операции', 'url'=>array('operations/index'),'visible'=>!Yii::app()->user->isGuest),
								array('label'=>'Счета', 'url'=>array('accounts/index'),'visible'=>!Yii::app()->user->isGuest),
								array('label'=>'Авторизация', 'url'=>array('site/login'), 'visible'=>Yii::app()->user->isGuest),
								array('label'=>'Регистрация', 'url'=>array('site/register'),'visible'=>Yii::app()->user->isGuest),
								array('label'=>'Выйти ('.Yii::app()->user->name.')', 'url'=>array('site/logout'), 'visible'=>!Yii::app()->user->isGuest)
							),
						)); ?>
					</div>
				</div>
			</div>
			<div class="row-fluid">
				<?php if(isset($this->breadcrumbs)):?>
					<?php $this->widget('zii.widgets.CBreadcrumbs', array(
						'htmlOptions'=>array('class'=>'breadcrumb'),
						'links'=>$this->breadcrumbs,
					)); ?><!-- breadcrumbs -->
				<?php endif?>
			</div>
			<div class="row-fluid">
				<div class="span9"><?php echo $content; ?></div>
			</div>
			<div class="row-fluid">
				<div class="container">
					<div class="span5">
						Copyright &copy; <?php echo date('Y'); ?> by BlaDe39.<br/>
						All Rights Reserved.<br/>
						<?php echo Yii::powered(); ?>
					</div>
				</div>
			</div>
		</div>
		<!-- Yandex.Metrika counter -->
		<script type="text/javascript">
			(function (d, w, c) {
				(w[c] = w[c] || []).push(function() {
					try {
						w.yaCounter17627431 = new Ya.Metrika({id:17627431, enableAll: true});
					} catch(e) { }
				});

				var n = d.getElementsByTagName("script")[0],
						s = d.createElement("script"),
						f = function () { n.parentNode.insertBefore(s, n); };
				s.type = "text/javascript";
				s.async = true;
				s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

				if (w.opera == "[object Opera]") {
					d.addEventListener("DOMContentLoaded", f);
				} else { f(); }
			})(document, window, "yandex_metrika_callbacks");
		</script>
		<noscript><div><img src="//mc.yandex.ru/watch/17627431" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->
	</body>
</html>
