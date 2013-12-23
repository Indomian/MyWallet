<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Добро пожаловать на сайт MyWallet</h1>
<p>
	Данный сайт предназначен для ведения учёта своих расходов и позволяет наиболее полно и легко контроллировать
	свои финансовые операции.
</p>
<p>Спасибо <a href="http://wiki.enchtex.info">wiki.enchtex.info</a> за помощь в организации работы сайта.</p>

<div>
        <ul>
                <li><a href="rtmp://itv08.digizuite.dk/tv2b" class="playerLink">Stream1</a></li>
	        <li><a href="http://stream.flowplayer.org/bauhaus/624x260.mp4" class="playerLink">Stream2</a></li>
	        <li><a href="/temp/1.mp3" class="playerLink">Stream3</a></li>
        </ul>
</div>
<div id="player"></div>

<script type="text/javascript">
$(document).ready(function(){
	jwplayer('player').setup({
		width:600,
		height:300,
		file:"/temp/1.mp3",
		primary:'flash',
		onReady:function(){
		},
		onSetupError:function(fallback,message) {
			alert(message);
		}
	});
	$('a.playerLink').click(function(e){
		e.preventDefault();
		var url= $(this).attr('href');
		jwplayer().stop();
		jwplayer().load([{file:url}]);
		jwplayer().play(true);
	});
});
</script>
